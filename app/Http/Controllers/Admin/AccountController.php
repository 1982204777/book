<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\AppAccessLog;
use App\Http\Models\User;
use Illuminate\Http\Request;

class AccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->input();
        $query = User::query();
        $status = array_get($input, 'status', -1);
        $keywords = array_get($input, 'keywords', '');
        $current_page = intval(array_get($input, 'p', 1));
        if ($current_page < 0) {
            $current_page = 1;
        }
        if ($status > -1) {
            $query->where('status', $status);
        }
        if ($keywords) {
            $query->where('nickname', 'like', '%' . $keywords . '%')
                ->orWhere('mobile', 'like', '%' . $keywords . '%');
        }
        $page = config('common.page');
        //分页
        $page['total_count'] = $query->count();
        $accounts = $query->orderBy('uid', 'desc')
            ->offset(($current_page - 1) * $page['page_size'])
            ->limit($page['page_size'])
            ->get();
        $status_mapping = config('common.status_mapping');
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $page['current_page'] = $current_page;

        return view('admin/account/index', compact('accounts', 'status_mapping', 'page', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/account/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateResult = $this->validateMiddle($request->input(), [
            'nickname' => 'required',
            'mobile' => 'required|min:8',
            'email' => 'required|email',
            'login_name' => 'required',
            'login_pwd' => 'required'
        ], [
            'nickname.required' => '请输入用户名~~~',
            'mobile.required' => '请输入合法的手机号~~~',
            'email.required' => '请输入邮箱~~~',
            'email.email' => '请输入合法邮箱~~~',
            'login_name.required' => '请输入登录名~~~',
            'login_pwd.required' => '请输入登录密码~~~',
        ]);
        if ($validateResult) {
            return $validateResult;
        }
        $store_data = request(['nickname', 'mobile', 'email', 'login_name', 'login_pwd']);
        $user = User::where('login_name', $store_data['login_name'])->first();
        if ($user) {
            return ajaxReturn('该登录名已存在，重新输入一个吧~~~', -1);
        }

        $user = new User();
        $user->nickname = $store_data['nickname'];
        $user->mobile = $store_data['mobile'];
        $user->email = $store_data['email'];
        $user->login_name = $store_data['login_name'];
        $user->setSalt();
        $user->setPassWord($store_data['login_pwd']);
        $user->avatar = config('common.default_avatar');
        $user->save();

        return ajaxReturn('添加成功~~~');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $app_access_logs = AppAccessLog::where('uid', $id)->orderBy('created_at', 'desc')->limit(10)->get();

        return view('admin/account/info', compact('user', 'app_access_logs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('admin/account/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateResult = $this->validateMiddle($request->input(), [
            'nickname' => 'required',
            'mobile' => 'required|min:8',
            'email' => 'required|email',
            'login_name' => 'required',
            'login_pwd' => 'required'
        ], [
            'nickname.required' => '请输入用户名~~~',
            'mobile.required' => '请输入合法的手机号~~~',
            'email.required' => '请输入邮箱~~~',
            'email.email' => '请输入合法邮箱~~~',
            'login_name.required' => '请输入登录名~~~',
            'login_pwd.required' => '请输入登录密码~~~',
        ]);
        if ($validateResult) {
            return $validateResult;
        }
        $update_data = request(['nickname', 'mobile', 'email', 'login_name', 'login_pwd']);
        $user = User::find($id);
        if (!$user) {
            return ajaxReturn('您指定的账号不存在', -1);
        }
        if (count(User::where('login_name', $update_data['login_name'])->get()) > 1) {
            return ajaxReturn('该登录名已存在，重新输入一个吧~~~', -1);
        }
        $currentUser = $this->getCurrentUser();
        $current_uid = $currentUser->uid;
        $current_pwd = $currentUser->login_pwd;

        $user->nickname = $update_data['nickname'];
        $user->mobile = $update_data['mobile'];
        $user->email = $update_data['email'];
        $user->login_name = $update_data['login_name'];
        if ($update_data['login_pwd'] !== $user->login_pwd) {
            $user->login_salt = getSalt();
            $user->login_pwd = md5($update_data['login_pwd'] . md5($user->login_salt));
        }
        $user->save();

        if ($user->uid == $current_uid && $user->login_pwd != $current_pwd) {
            $this->setLoginStatus();
        }

        return ajaxReturn('编辑成功~~~');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ops()
    {
        $uid = request('uid');
        $act = request('act');
        if (!$uid) {
            return ajaxReturn('请选择要操作的账号~~~');
        }
        if (!in_array($act, ['remove', 'recover'])) {
            return ajaxReturn('操作有误，请重试~~~');
        }
        $user = User::find($uid);
        if (!$user) {
            return ajaxReturn('您指定的账号不存在~~~');
        }
        switch ($act){
            case "remove":
                $user->status = 0;
                $act = '删除成功~~~';
                break;
            case "recover":
                $user->status = 1;
                $act = '恢复成功~~~';
        };
        $user->save();

        return ajaxReturn($act);
    }
}
