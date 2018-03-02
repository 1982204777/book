<?php

namespace App\Http\Middleware;


use App\Http\Models\Member;
use App\Http\Models\OauthMemberBind;
use App\Http\Services\ConstantMapService;
use App\Http\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckWechatLogin
{
    protected $allow_action = [
        '/m/home',
        '/m',
        '/m/product',
        '/m/product/search',
        '/m/product/info',
        '/m/product/share'
    ];

    public function handle(Request $request,\Closure $next)
    {
        $share_info = config('common.share_info');
        $share_info['img_url'] = 'http://' . $request->getHttpHost() . '/images/m/test.jpg';
        \View::composer('m.layout.footer', function($view) use ($share_info){
            $view->with('share_info', json_encode($share_info));
        });
        $is_login = $this->checkLogin();

        if (!$is_login) {
            if (request()->ajax() && !in_array($request->getPathInfo(), $this->allow_action)) {
                return response([
                    'msg' => '未登录，请先登录~~~',
                    'code' => 400
                ], 400);
            } else {
                $res = $this->checkAndLogin();
                if ($res === true) {
                    return $next($request);
                } else {
                    return redirect($res);
                }
            }
        }

        $request->attributes->add(['member' => $is_login]);


        \View::composer('m.welcome', function($view) use ($is_login, $share_info){
            $view->with('user', $is_login);
            $view->with('share_info', json_encode($share_info));
        });
        return $next($request);
    }

    public function checkLogin()
    {
        $auth_cookie = Cookie::get('book_member');
        if (!$auth_cookie) {
            return false;
        }

        list($member_id, $auth_token) = explode("#",$auth_cookie);
        if(!$auth_token || !$member_id) {
            return false;
        }
        if($member_id && preg_match("/^\d+$/",$member_id)){
            $member_info = Member::where('id', $member_id)
                ->where('status', 1)
                ->first();
            if(!$member_info){
                return false;
            }

            $auth_token_md5 = md5(config('common.wechat_login_salt') . "-{$member_info['id']}-{$member_info['mobile']}-{$member_info['salt']}");
            if( $auth_token != $auth_token_md5){
                return false;
            }

            if (UtilService::isWechat()) {
                $openid = Cookie::get('book_m_openid');
                $reg_bind = OauthMemberBind::where('openid', $openid)
                    ->where('type', ConstantMapService::$client_type_wechat)
                    ->first();

                if (!$reg_bind) {
                    return false;
                }
            }

            return $member_info;
        }
        return false;
    }

    public function checkAndLogin()
    {
        $redirect_url = 'm/bind';
//        微信
        if (UtilService::isWechat()) {
            $openid = Cookie::get('book_m_openid');
            if (!$openid) {
//                登录
                $redirect_url = 'm/oauth/login';
            } else {
                if (in_array(\request()->getPathInfo(), $this->allow_action)) {
                    return true;
                }
            }
        } else {
//            H5
            if (in_array(\request()->getPathInfo(), $this->allow_action)) {
                return true;
            }
        }

        return $redirect_url;
    }
}
