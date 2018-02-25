<?php

namespace App\Http\Controllers\Wechat;


class UserController extends BaseController
{
    public function index()
    {
        return view('m/user/index');
    }
}
