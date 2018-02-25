<?php

namespace App\Http\Controllers\Wechat;


class ProductController extends BaseController
{
    public function index()
    {
        return view('m/product/index');
    }
}
