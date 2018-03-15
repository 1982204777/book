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
                    'url' => 'http://1720t49i53.iok.la/m/home'
                ],
                [
                    'name' => '我',
                    'type' => 'view',
                    'url' => 'http://1720t49i53.iok.la/m/user'
                ]
            ]
        ];

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
//        dd(post('http://pay.trsoft.xin/order/trpayGetWay', [
//            'name' => '12312321',
//            'tradeName' => '一个月会员',
//            'amount' => "10",
//            'appkey' => 'appkey',
//            'payType' => '1',
//            'notifyUrl' => 'http://www.uc.com',
//            'synNotifyUrl' => 'http://www.baidu.com',
//            'payuserid' => '1',
//            'method' => 'trpay.trade.create.wap',
//            'version' => '1.0',
//            'timestamp' => '1515816424071',
//            'sign' => '827A00D01F0CF39C6EE3AD1FD0E0E384'
//        ]));
        logger(request()->input());
        dd(request()->input());
    }
}
