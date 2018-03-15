<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Models\MemberCart;
use App\Http\Models\MemberFav;
use App\Http\Models\order\PayOrder;
use App\Http\Services\ConstantMapService;
use function foo\func;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index()
    {
        $user = request()->attributes->get('member');

        return view('m/user/index', compact('user'));
    }

    public function cart()
    {
        $member = request()->attributes->get('member');
        $carts = MemberCart::where('member_id', $member->id)
            ->with('book')
            ->get();
        $total_price = 0;
        foreach ($carts as $cart) {
            $total_price += $cart->quantity * $cart->book->price;
        }
        $total_price = number_format($total_price, 2, '.', '');

        return view('m/user/cart', compact('carts', 'total_price'));
    }

    public function order(Request $request)
    {
        $member = $request->attributes->get('member');
        $pay_orders = PayOrder::where('member_id', $member->id)
                    ->orderBy('created_at', 'desc')
                    ->with(['items' => function($q) {
                        return $q->with('book');
                    }])
                    ->get()
                    ->toArray();
//        dd($pay_orders);
        $pay_status_mapping = ConstantMapService::$pay_status_mapping;

        return view('m/user/order', compact('pay_orders', 'pay_status_mapping'));
    }

    public function orderOps(Request $request)
    {
        $pay_order_id = $request->post('pay_order_id', 0);
        if (!$pay_order_id) {
            return ajaxReturn('请选择订单~~~', -1);
        }
        $pay_order = PayOrder::find($pay_order_id);
        if (!$pay_order) {
            return ajaxReturn('该订单不存在~~~', -1);
        }
        $pay_order->status = 0;
        if ($res = $pay_order->save()) {
            return ajaxReturn('操作成功~~~');
        }
    }

    public function fav()
    {
        $member = request()->attributes->get('member');
        $favs = MemberFav::where('member_id', $member->id)
            ->with('book')
            ->get();

        return view('m/user/fav', compact('favs'));
    }

    public function comment()
    {
        return view('m/user/comment');
    }

}
