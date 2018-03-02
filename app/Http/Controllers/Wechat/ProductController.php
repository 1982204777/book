<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Models\Book;
use App\Http\Models\MemberCart;
use App\Http\Models\MemberFav;
use App\Http\Services\ConstantMapService;
use Illuminate\Http\Request;

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

        if (!$quantity || !$book_id) {
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
}
