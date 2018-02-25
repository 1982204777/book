<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Models\Member;
use App\Http\Models\OauthMemberBind;
use App\Http\Services\ConstantMapService;
use App\Http\Services\HttpClient;
use Illuminate\Http\Request;

class OauthController extends BaseController
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
            return $this->goHome();
        }

        $scope = isset($res['scope']) ? $res['scope'] : '';
        $openid = isset($res['openid']) ? $res['openid'] : '';

        $this->setCookie($this->auth_cookie_current_openid, $openid);

        $reg_bind = OauthMemberBind::where('openid', $openid)
                ->where('type', ConstantMapService::$client_type_wechat)
                ->first();

        if ($reg_bind) {
            $member_info = Member::where('id', $reg_bind->member_id)
                    ->where('status', 1)
                    ->first();
            if (!$member_info) {
                $reg_bind->delete();
                return $this->goHome();
            }

            if ($scope == 'snsapi_userinfo') {
                $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
                $wechat_user_info = HttpClient::get($url);
                $wechat_user_info = json_decode($wechat_user_info, true);

                //这个时候做登录特殊处理，例如更新用户名和头像等等新
//            if( $member_info->avatar == ConstantMapService::$default_avatar ){
                //需要做一个队列数据库了
                //$wechat_user_info['headimgurl']
//                QueueListService::addQueue( "member_avatar",[
//                    'member_id' => $member_info['id'],
//                    'avatar_url' => $wechat_user_info['headimgurl'],
//                ] );
//            }

                if ($member_info['nickname'] == $member_info['mobile'] ) {
                    $member_info->nickname = isset($wechat_user_info['nickname']) ? $wechat_user_info['nickname'] : $member_info->nickname;
                    $member_info->save();
                }
            }
            $this->setLoginStatus($member_info);
        } else {
            $this->removeLoginStatus();
        }

        return redirect('m/home');

    }
}
