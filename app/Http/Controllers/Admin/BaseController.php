<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Services\AppLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{
    protected $auth_cookie_name = 'book_user';

    public function __construct()
    {
        $user = $this->getCurrentUser();
        \View::composer('admin.layout.navbar', function($view) use ($user){
            $view->with('user', $user);
        });

        $currentUser = $this->getCurrentUser();
        if ($currentUser) {
            AppLogService::addAppAccessLog($this->getCurrentUser()->uid);
        }

        return true;
    }

    public function getCurrentUser()
    {
        $auth_cookie = Cookie::get('book_user');
        $uid = explode('#', $auth_cookie)[0];
        $user = User::where('uid', $uid)->first();

        return $user;
    }

    protected function validateMiddle($input, $rules, $messages)
    {
        $validator = $this->getValidationFactory()->make($input, $rules, $messages);
        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 406);
        }
        return false;
    }

    public function setLoginStatus()
    {
        $user = $this->getCurrentUser();
        $auth_token = $user->uid . '#' .md5($user->login_name . $user->login_pwd . $user->login_salt);
        Cookie::queue($this->auth_cookie_name, $auth_token, 1440);
    }
}
