<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    protected $auth_cookie_name = 'book_user';

    public function index(Request $request)
    {
        if ($request->cookie('book_user')) {
            $this->middleware('CheckLogin');
            return redirect('/admin/home');
        }
        return view('admin/login/index');
    }

    public function login()
    {
        $login_name = request('login_name');
        $login_pwd = request('login_pwd');

        if (!$login_name || !$login_pwd) {
            return normalReturn('用户名或密码不能为空~~~', '/admin/login');
        }

        $user = User::where('login_name', $login_name)->first();
        if (!$user) {
            return normalReturn('该用户不存在', '/admin/login');
        }

        //密码加密算法 = md5(login_pwd + md5(login_salt))
        $auth_pwd = md5($login_pwd . md5($user->login_salt));
        if ($auth_pwd == $user->login_pwd) {
            //保存用户的登陆状态
            //加密字符串 + # + uid    加密字符串 = md5(login_name + login_pwd + login_salt)
            $auth_token = $user->uid . '#' .md5($login_name . $user->login_pwd . $user->login_salt);
            Cookie::queue($this->auth_cookie_name, $auth_token, 1440);
            return redirect('admin/home')->withCookie($this->auth_cookie_name);
        } else {
            return normalReturn('密码错误', '/admin/login');
        }
    }

    public function logout()
    {
        $cookie = Cookie::forget($this->auth_cookie_name);
        return redirect('/admin/login')->withCookie($cookie);
    }
}
