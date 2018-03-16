<?php

namespace App\Http\Controllers\Wechat\wx;

use App\Http\Controllers\Controller;
use App\Http\Services\wechat\RequestService;

class MenuController extends Controller
{

    public function setMenu()
    {
        $menu = [
            'button' => [
                [
                    'name' => '商城',
                    'type' => 'view',
                    'url' => 'http://www.wangyouquan.cc/m/home'
                ],
                [
                    'name' => '我',
                    'type' => 'view',
                    'url' => 'http://www.wangyouquan.cc/m/user'
                ]
            ]
        ];

        RequestService::setApp();
        $access_token = RequestService::getAccessToken();
        if (!$access_token) {
            return null;
        }
        $path = 'menu/create?access_token=' . $access_token;
        $res = RequestService::send($path, json_encode($menu, JSON_UNESCAPED_UNICODE), 'POST');

        return $res;
    }

    public function test()
    {

    }
}
