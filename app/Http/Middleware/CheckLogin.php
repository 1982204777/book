<?php

namespace App\Http\Middleware;


use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckLogin
{
    public function handle(Request $request,\Closure $next)
    {
        $is_login = $this->checkLogin();
        if (!$is_login) {
            if (request()->ajax()) {
                return response('未登录，请先登录~~~');
            } else {
                return redirect('/admin/login');
            }
        }

        $request->attributes->add(['user' => $is_login]);
        return $next($request);
    }

    public function checkLogin()
    {
        $auth_cookie = Cookie::get('book_user');
        if (!$auth_cookie) {
            return false;
        }

        list($uid, $auth_token) = explode('#', $auth_cookie);

        if (!$auth_token || !$uid) {
            return false;
        }

        if (!preg_match("/^\d+$/", $uid)) {
            return false;
        }

        $user = User::where('uid', $uid)->first();
        if (!$user) {
            return false;
        }

        $auth_token_md5 = md5($user->login_name . $user->login_pwd . $user->login_salt);
        if ($auth_token != $auth_token_md5) {
            return false;
        }

        return $user;
    }
}
