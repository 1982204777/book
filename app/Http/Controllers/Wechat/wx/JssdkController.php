<?php

namespace App\Http\Controllers\Wechat\wx;


use App\Http\Services\wechat\RequestService;
use Illuminate\Support\Facades\Cache;

class JssdkController
{
    public function index()
    {
        $ticket = $this->getJsapiTicket();
        $url = request()->get("url");
        $timestamp = time();
        $noncestr = $this->createNoncestr( );
        $string = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$url}";
        $signature = sha1( $string );

        $data = [
            'appId' => env('APP_ID'),
            'timestamp' => $timestamp,
            'nonceStr' => $noncestr,
            'signature' => $signature,
            'string' => $string
        ];

        return ajaxReturn($data);
    }

    private function getJsapiTicket()
    {
        $cache_key = 'wechat_jsticket';
        $wechat_jsticket = Cache::get($cache_key);
        if (!$wechat_jsticket) {
            $access_token = RequestService::getAccessToken();
            $res = RequestService::send("ticket/getticket?access_token={$access_token}&type=jsapi");
            if (isset($res['errcode']) && $res['errcode'] == 0) {
                Cache::add($cache_key, $res['ticket'], $res['expires_in'] - 200);
                return $res['ticket'];
            }
        }

        return $wechat_jsticket;
    }

    private function createNoncestr( $length = 16 ){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = '';
        for( $i =0 ;$i < $length ;$i++){
            $str .= substr( $chars,mt_rand( 0,strlen( $chars ) - 1 ),1 );
        }
        return $str;
    }
}