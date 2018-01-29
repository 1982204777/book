<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Models\BrandImage;
use App\Http\Models\BrandSetting;

class WelcomeController extends Controller
{
    public function index()
    {
        $brand_info = BrandSetting::first();
        $brand_images = BrandImage::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('m/welcome', compact('brand_info', 'brand_images'));
    }
}
