<?php

namespace App\Http\Middleware;


use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Mockery\Exception;

class CheckLogin
{
    public function handle(Request $request,\Closure $next)
    {
        $is_login = $this->checkLogin();
        if (!$is_login) {
            if (request()->ajax()) {
                return response('未登录，请先登录~~~');
            } else {
                Cookie::queue(Cookie::forget('book_user'));
                return response("<script>window.location.href='login'</script>");
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

        $id_token_info = explode('#', $auth_cookie);

        if (count($id_token_info) < 2) {
            return false;
        }
        $uid = $id_token_info[0];
        $auth_token = $id_token_info[1];

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
