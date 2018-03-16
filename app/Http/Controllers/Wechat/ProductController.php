<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Models\Book;
use App\Http\Models\City;
use App\Http\Models\MemberAddress;
use App\Http\Models\MemberCart;
use App\Http\Models\MemberFav;
use App\Http\Models\order\PayOrder;
use App\Http\Models\WechatShareHistory;
use App\Http\Services\ConstantMapService;
use App\Http\Services\pay\PayOrderService;
use App\Http\Services\trpay\PayApiService;
use Illuminate\Http\Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends BaseController
{
    public function index(Request $request)
    {
        $input = $request->input();
        $keywords = array_get($input, 'kw', '');
        $sort_field = array_get($input, 'sort_field', 'default');
        $sort = array_get($input, 'sort', '');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';

        $list = $this->getSearchData();
        $search_conditions = [
            'kw' => $keywords,
            'sort_field' => $sort_field,
            'sort' => $sort
        ];

        return view('m/product/index', compact('list', 'search_conditions'));
    }

    private function getSearchData($page_size = 4)
    {
        $input = \request()->input();
        $keywords = array_get($input, 'kw', '');
        $sort_field = array_get($input, 'sort_field', 'default');
        $sort = array_get($input, 'sort', '');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';
        $p = intval(array_get($input, 'p', 1));

        $query = Book::query();
        if ($keywords) {
            $query->where('name', 'like', '%' . $keywords . '%')
                ->orWhere('tags', 'like', '%' . $keywords . '%');
        }
        switch ($sort_field) {
            case 'view_count':
                $query->orderBy('view_count', $sort);
                break;
            case 'month_count':
                $query->orderBy('month_count', $sort);
                break;
            case 'price':
                $query->orderBy('price', $sort);
                break;
            default:
                $query->orderBy('id', $sort);
        }

        return $query->offset(($p - 1) * $page_size)
            ->limit($page_size)
            ->get();
    }

    public function search()
    {
        $list = $this->getSearchData( );
        $data = [];
        if( $list ){
            foreach( $list as $book ){
                $data[] = [
                    'id' => $book->id,
                    'name' => $book->name,
                    'price' => $book->price,
                    'main_image_url' => $book->main_img,
                    'month_count' => $book->month_count
                ];
            }
        }
        return [
            'data' => $data,
            'has_next' => count($data) == 4 ? 1 : 0,
            'code' => 0
        ];
    }

    public function show()
    {
        $id = \request('id');
        $book = Book::find($id);

        if ($member = \request()->attributes->get('member')) {
            $member_fav = MemberFav::where('member_id', $member->id)->where('book_id', $book->id)->first();

            return view('m/product/info', compact('book', 'member_fav'));
        }

        return view('m/product/info', compact('book'));
    }

    /**
     * 收藏
     */
    public function fav(Request $request)
    {
        $act = $request->post('act');
        $member = $request->attributes->get('member');
        $book_id = $request->post('book_id');
        if (!in_array($act, ['del', 'set'])) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }

//        删除
        if ($act == 'del') {
            $id = $request->post('id', '');
            if (!$id) {
                return ajaxReturn(ConstantMapService::$default_system_err, -1);
            }
            $fav = MemberFav::find($id);
            if (!$fav) {
                return ajaxReturn(ConstantMapService::$default_system_err, -1);
            }

            $fav->delete();

            return ajaxReturn('操作成功~~~', MemberFav::where('member_id', $member->id)->count() ? 0 : 2);
        }

        if (!$book_id) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);

        }
//        收藏
        if (!Book::find($book_id)) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }

        $member_fav = MemberFav::where('member_id', $member->id)
            ->where('book_id', $book_id)
            ->first();

        if ($member_fav) {
            return ajaxReturn('已收藏~~~', -1);
        }

        $member_fav = MemberFav::create([
            'member_id' => $member->id,
            'book_id' => $book_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if ($member_fav) {
            return ajaxReturn('收藏成功~~~');
        }
    }

    /**
     * 浏览量
     */
    public function ops(Request $request)
    {
        $book_id = $request->post('book_id');
        $book = Book::find($book_id);
        if (!$book) {
            return ajaxReturn(ConstantMapService::$default_system_err);
        }
        $book->view_count += 1;
        $book->save();

        return ajaxReturn('闪闪惹人爱~~~');
    }

    /**
     * 加入购物车
     */
    public function addToCart(Request $request)
    {
        $act = $request->post('act');
        $book_id = $request->post('book_id');
        $quantity = $request->post('quantity');
        $member_id = $request->attributes->get('member')->id;

        if (!in_array($act, ['set', 'del'])) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }

        if ($act == 'del') {
            $id = $request->post('id', '');
            if (!$id) {
                return ajaxReturn(ConstantMapService::$default_system_err, -1);
            }
            $cart = MemberCart::find($id);
            if (!$cart) {
                return ajaxReturn(ConstantMapService::$default_system_err, -1);
            }
            $cart->delete();

            return ajaxReturn('操作成功~~~', MemberCart::where('member_id', $member_id)->count() ? 0 : 2);
        }

        if (!$quantity) {
            return ajaxReturn('至少购买一本吧亲~~~');
        }
        if (!$book_id) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }

        if (!Book::find($book_id)) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
        $cart_info = MemberCart::where('book_id', $book_id)
                ->where('member_id', $member_id)
                ->first();
        if ($cart_info) {
            if ($request->post('update')) {
                $cart_info->quantity = $quantity;
            } else {
                $cart_info->quantity += $quantity;
            }
//            todo 购物车库存判断
            $cart_info->save();
        } else {
            $cart_info = new MemberCart();
            $cart_info->book_id = $book_id;
            $cart_info->member_id = $member_id;
            $cart_info->quantity = $quantity;
            $cart_info->save();
        }

        if ($cart_info) {
            return ajaxReturn('操作成功~~~');
        }
    }

//    分享
    public function share()
    {
        $url = \request()->post('url', '');
        if (!$url) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
        $member = \request()->attributes->get('member');
        $member_id = $member ? $member->id : 0;

        $wechat_share_history = new WechatShareHistory();
        $wechat_share_history->member_id = $member_id;
        $wechat_share_history->share_url = $url;
        $wechat_share_history->created_at = date('Y-m-d H:i:s');
        $wechat_share_history->save();

        return ajaxReturn('保存成功~~~');
    }

    public function order(Request $request)
    {
        $book_id = $request->post('book_id', 0);
        $quantity = $request->get('quantity', 0);
        if ($request->isMethod('get')) {
            $book = Book::find($book_id);
            $member = $request->attributes->get('member');
            $member_addresses = MemberAddress::where('member_id', $member->id)
                ->where('status', 1)
                ->get();
            $product_list[] = [
                'id' => $book_id,
                'name' => $book->name,
                'price' => $book->price,
                'quantity' => $quantity,
                'main_img' => $book->main_img,
            ];

            $area_ids = $member_addresses->pluck('area_id')->toArray();
            $city_mapping = City::whereIn('id', $area_ids)
                    ->select(['province', 'city', 'area', 'id'])
                    ->get()
                    ->keyBy('id')
                    ->toArray();
            
            $address_list = [];
            foreach ($member_addresses as $key => $address) {
                $tmp_address = '';
                $tmp_address_info = $city_mapping[$address['area_id']];
                $tmp_address .= $tmp_address_info['province'] . $tmp_address_info['city'] . $tmp_address_info['area'] . $address->address;
                $address_list[$key]['address'] = $tmp_address;
                $address_list[$key]['name'] = $address->nickname;
                $address_list[$key]['mobile'] = $address->mobile;
                $address_list[$key]['id'] = $address->id;
                $address_list[$key]['is_default'] = $address->is_default;
            }
            $total_price = sprintf('%.2f', $book->price * $quantity);
            return view('m/product/order', compact('address_list', 'product_list', 'total_price'));
        }

        $book = Book::find($book_id);
        if (!$book) {
            return ajaxReturn('请选择要购买的图书~~~', -2);
        }
        if (!$quantity) {
            return ajaxReturn('至少购买一本吧亲~~~', -1);
        }

        return ajaxReturn('success');
    }

    public function cartOrder(Request $request)
    {
        $cart_ids = $request->post('cart_ids', []);
        if ($request->isMethod('get')) {
            $cart_ids = explode(',', $cart_ids);
            $carts = MemberCart::whereIn('id', $cart_ids)
                    ->with('book')
                    ->get()
                    ->toArray();
            $product_list = [];
            foreach ($carts as $key => $cart) {
                $product_list[$key]['id'] = $cart['book']['id'];
                $product_list[$key]['name'] = $cart['book']['name'];
                $product_list[$key]['main_img'] = $cart['book']['main_img'];
                $product_list[$key]['price'] = $cart['book']['price'];
                $product_list[$key]['quantity'] = $cart['quantity'];
                $product_list[$key]['total_price'] = sprintf('%.2f', $cart['quantity'] * $cart['book']['price']);
            }
            $member_id = $request->attributes->get('member')->id;
            $member_addresses = MemberAddress::where('member_id', $member_id)
                    ->where('status', 1)
                    ->get()
                    ->toArray();
            $city_mapping = City::whereIn('id', array_column($member_addresses, 'area_id'))
                    ->select('id', 'province', 'city', 'area')
                    ->get()
                    ->keyBy('id')
                    ->toArray();
            $address_list = [];
            foreach ($member_addresses as $key => $address) {
                $tmp_address = '';
                $tmp_address_info = $city_mapping[$address['area_id']];
                $tmp_address .= $tmp_address_info['province'] . $tmp_address_info['city'] . $tmp_address_info['area'] . $address['address'];
                $address_list[$key]['address'] = $tmp_address;
                $address_list[$key]['name'] = $address['nickname'];
                $address_list[$key]['mobile'] = $address['mobile'];
                $address_list[$key]['id'] = $address['id'];
                $address_list[$key]['is_default'] = $address['is_default'];
            }
            $total_price = 0;
            foreach ($product_list as $item) {
                $total_price += $item['total_price'];
            }
            $total_price = sprintf('%.2f', $total_price);

            return view('m/product/order', compact('address_list', 'product_list', 'total_price'));
        }

        if (!$cart_ids) {
            return ajaxReturn('请选择要购买的图书~~~', -1);
        }

        return ajaxReturn('success');
    }

    public function placeOrder(Request $request)
    {
        $product_items = $request->post('product_items', []);
        $address_id = $request->post('address_id', 0);
        $source = $request->post('source', '');
        if (!$product_items) {
            return ajaxReturn('请选择商品之后再提交~~~', -1);
        }
        if (!$address_id) {
            return ajaxReturn('请选择收货地址~~~', -1);
        }
        $member = $request->attributes->get('member');
        $items = $book_quantity_mapping = [];
        foreach ($product_items as $item) {
            $tmp_book_info = explode('#', $item);
            $book_quantity_mapping[$tmp_book_info[0]] = $tmp_book_info[1];
        }
        $book_ids = array_keys($book_quantity_mapping);
        $book_mapping = Book::whereIn('id', $book_ids)
                ->where('status', 1)
                ->get()
                ->keyBy('id');

        if ($book_mapping->isEmpty()) {
            return ajaxReturn('请选择商品之后再提交~~~', -1);
        }
        $target_type = 1;
        foreach ($product_items as $item) {
            $tmp_book_info = explode('#', $item);
            $items[] = [
                'name' => $book_mapping[$tmp_book_info[0]]['name'],
                'price' => $book_mapping[$tmp_book_info[0]]['price'],
                'quantity' => $tmp_book_info[1],
                'target_type' => $target_type,
                'target_id' => $tmp_book_info[0]
            ];
        }

        $params = [
            'pay_type' => 1,
            'pay_source' => 2,
            'target_type' => $target_type,
            'note' => '购买书籍',
            'status' => -8,
            'express_address_id' => $address_id
        ];

        $res = PayOrderService::placePayOrder($member->id, $items, $params);
        if (!$res) {
            return ajaxReturn('提交失败，失败原因：' . PayOrderService::getLastErrorMsg(), PayOrderService::getLastErrorCode());
        }
        //如果从购物车创建订单，需要清空购物车了
        if ($source == "cart") {
            MemberCart::where('member_id', $member->id)
                ->delete();
        }

        return ajaxReturn([
            'url' => 'order/pay?pay_order_id=' . $res['id'],
            'msg' => '下单成功，前去支付~~~'
        ]);
    }

    public function payView(Request $request)
    {
        $pay_order_id = $request->get('pay_order_id', 0);
        if (!$pay_order_id) {
            return back();
        }
        $pay_order_info = PayOrder::find($pay_order_id);
        if (!$pay_order_info) {
            return "<script>alert('订单错误~~~');window.location.href = '/m/product';</script>";
        }
        $member = $request->attributes->get('member');
        $book_name_string = '';
        foreach ($pay_order_info['items'] as $item) {
            $book_name_string .= $item['book']['name'] . '*' . $item['quantity'];
            if (count($pay_order_info) > 1) {
                $book_name_string .= '，';
            }
        }
        $trpay = new PayApiService();
        $timestamp = time();
        $trpay->setParameter('outTradeNo', $pay_order_info->order_sn);
        $trpay->setParameter('payType', '2');
        $trpay->setParameter('tradeName', $book_name_string);
        $trpay->setParameter('amount', $pay_order_info->pay_price * 100);
        $trpay->setParameter('notifyUrl', 'http://1720t49i53.iok.la/m/product/order/pay/callback');
//        $trpay->setParameter('synNotifyUrl', 'www.wangyouquan.cc/m/test');
        $trpay->setParameter('payuserid', $member->id);
        $trpay->setParameter('appkey', env('TRPAY_APP_KEY'));
        $trpay->setParameter('method', 'trpay.trade.create.scan');
        $trpay->setParameter('timestamp', $timestamp);
        $trpay->setParameter('version', '1.0');
//        $trpay->setParameter('ipAddress', UtilService::getIP());
        $params = $trpay->getSignParams();
        $res = post('http://pay.trsoft.xin/order/trpayGetWay', $params);
        $res = json_decode($res, true);
        if (isset($res['code']) && $res['code'] == '0000') {
            $wechat_pay_url = $res['data']['qrcode'];
        } else {
            return back();
        }
        if (!is_dir('images/qrcodes/pay')) {
            mkdir(iconv("UTF-8", "GBK", 'images/qrcodes/pay'),0777,true);
        }
        QrCode::format('png')->size(200)->generate($wechat_pay_url, public_path("/images/qrcodes/pay/" . $pay_order_id .".png"));

        return view('m/product/pay', compact('pay_order_info'));
    }

    public function payCallback()
    {
        $check_result = $this->callbackCheck();
        if (!$check_result) {
            return 'failed';
        }
        $pay_order = PayOrder::where('order_sn', $check_result['outTradeNo'])
                ->first();
        if (!$pay_order) {
            return 'failed';
        }
        if ($pay_order->pay_price != $check_result['amount'] / 100) {
            return 'failed';
        }
        $params = [

        ];
        PayOrderService::orderSuccess($pay_order->id, $params);
        //记录支付回调信息
        PayOrderService::setPayOrderCallbackData($pay_order->id, 'pay', json_encode($check_result));

        if (PayOrderService::getLastErrorMsg()) {
            return 'failed';
        }

        return 'success';
    }

    private function callbackCheck()
    {
        $res = \request()->post();
        if (!$res) {
            return false;
        }

        if (!isset($res['status']) || $res['status'] == 3) {
            return false;
        }
        $pay_service = new PayApiService();
        foreach ($res as $key => $item) {
            if (in_array($key, ['sign'])) {
                continue;
            }
//            if (in_array($key, ['tradeName'])) {
//                $pay_service->setParameter($key, decodeUnicode($item));
//                continue;
//            }
            $pay_service->setParameter($key, $item);
        }

        $tmp_sign_params = $pay_service->getSignParams();

        if ($tmp_sign_params['sign'] != $res['sign']) {
            return false;
        }

        return $tmp_sign_params;
    }

    public function record_callback($msg)
    {
        $request_uri = request()->getRequestUri();
        $post_data = request()->post();
        $log = [
            "[url:{$request_uri}][post:" . http_build_query($post_data) . "][msg:$msg]",
            1,
            'application',
            microtime(true)
        ];
        $log_obj = new Logger('wechat-pay');
        $log_obj->pushHandler(new StreamHandler(storage_path('logs/online_pay_'. date('Y-m-d') . '.log')), Logger::INFO);
        $log_obj->info('wechat-pay', $log);
    }
}
