<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Services\HttpClient;
use Illuminate\Http\Request;

class OauthController
{
    public function login()
    {
        $scope = request()->get('scope', 'snsapi_base');
        $app_id = env('APP_ID', '');
        $redirect_uri = \url('m/oauth/callback');
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$app_id}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=#wechat_redirect";

        return redirect($url);
    }

    public function callback(Request $request)
    {
        $code = $request->get('code', '');
//        通过code获取网页授权的access_token
        $app_id = env('APP_ID', '');
        $app_secret = env('APP_SECRET', '');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$app_id}&secret={$app_secret}&code={$code}&grant_type=authorization_code";
        $res = HttpClient::get($url);
        $res = json_decode($res, true);

        $access_token = isset($res['access_token']) ? $res['access_token'] : '';
        if (!$access_token) {
            return $res;
        }

        $scope = isset($res['scope']) ? $res['scope'] : '';
        $openid = isset($res['openid']) ? $res['openid'] : '';
        if ($scope == 'snsapi_userinfo') {
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $request_res = HttpClient::get($url);
            $request_res = json_decode($request_res, true);
            return $request_res;
        }

        return $res;
    }
}
