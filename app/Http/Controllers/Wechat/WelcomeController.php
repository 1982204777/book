<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Models\BrandImage;
use App\Http\Models\BrandSetting;
use Illuminate\Support\Facades\Cookie;

class WelcomeController extends BaseController
{
    public function index()
    {
        $brand_info = BrandSetting::first();
        $brand_images = BrandImage::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('m/welcome', compact('brand_info', 'brand_images'));
    }

    public function cookieClear()
    {
        Cookie::queue(Cookie::forget('book_member'));
        Cookie::queue(Cookie::forget('book_m_openid'));
    }

    public function pay()
    {
        return view('m/user/pay');
    }
}
