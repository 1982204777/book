<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Controllers\Controller;
use App\Http\Services\UtilService;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{
    protected $auth_cookie_current_openid = "book_m_openid";
    protected  $auth_cookie_name = "book_member";
    protected $current_user = null;

    public function setLoginStatus($member_info)
    {
        $auth_token = $this->geneAuthToken($member_info);
        Cookie::queue($this->auth_cookie_name, $member_info->id . '#' .$auth_token);
    }

    public function removeLoginStatus()
    {
        Cookie::queue(Cookie::forget($this->auth_cookie_name));
    }

    public function geneAuthToken($member_info)
    {
        return md5(config('common.wechat_login_salt') . "-{$member_info['id']}-{$member_info['mobile']}-{$member_info['salt']}");
    }

    public function setCookie($name, $value, $expire = 0)
    {
        Cookie::queue($name, $value, $expire);
    }

    public function getCookie($key)
    {
        $cookie = Cookie::get($key);

        return $cookie;
    }

    public function goHome()
    {
        return redirect('m/home');
    }

}