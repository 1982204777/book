<?php

namespace App\Http\Services\wechat;


use App\Http\Models\OauthAccessToken;
use App\Http\Services\BaseService;
use App\Http\Services\HttpClient;

class RequestService extends BaseService
{
    private static $app_token = '';

    private static $app_id = '';

    private static $app_secret = '';

    private static $url_prefix = 'https://api.weixin.qq.com/cgi-bin/';

    public static function getAccessToken()
    {
        $now = date('Y-m-d H:i:s');
        $access_token_model = OauthAccessToken::where('expire_time', '>', $now)
            ->limit(1)
            ->first();
        if ($access_token_model) {
            return $access_token_model->access_token;
        }

//        调用接口获取access_token
        $path = 'token?grant_type=client_credential&appid=' . self::getAppId() . '&secret=' . self::getAppSecret();
        $res = self::send($path);
        if (!$res) {
            return self::err(self::getLastErrorMsg());
        }

        $model_access_token = new OauthAccessToken();
        $model_access_token->access_token = $res['access_token'];
        $model_access_token->expire_time = date('Y-m-d H:i:s', $res['expires_in'] + time() - 200);
        $model_access_token->created_at = $now;
        $model_access_token->save();

        return $model_access_token->access_token;
    }

    public static function send($path, $data = [], $method = 'GET')
    {
        $request_url = self::$url_prefix . $path;
        $res = [];
        if (strtolower($method) == 'get') {
            $res = HttpClient::get($request_url, []);
        }
        if (strtolower($method) == 'post') {
            $res = HttpClient::post($request_url, $data);
        }
        $res = json_decode($res, true);
        if (!$res || (isset($res['errcode']) && $res['errcode'])) {
            return self::err($res['errmsg'], $res['errcode']);
        }

        return $res;
    }

    public static function setApp()
    {
        self::$app_id = env('APP_ID');
        self::$app_secret = env('APP_SECRET');
    }

    public static function getAppId()
    {
        return self::$app_id;
    }

    public static function getAppSecret()
    {
        return self::$app_secret;
    }

    public static function getAppToken()
    {
        return self::$app_token;
    }
}