<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Models\MemberCart;
use App\Http\Models\MemberFav;

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

    public function order()
    {
        return view('m/user/order');
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
