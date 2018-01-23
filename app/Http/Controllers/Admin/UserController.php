<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
//    public function __construct(Request $request)
//    {
//        parent::__construct($request);
//    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin/user/edit', ['user' => $this->getCurrentUser()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validateResult = $this->validateMiddle($request->input(), [
            'nickname' => 'required',
            'email' => 'required|email',
        ], [
            'nickname.required' => '请输入用户名~~~',
            'email.required' => '请输入邮箱~~~',
            'email.email' => '请输入合法邮箱~~~',
        ]);
        if ($validateResult) {
            return $validateResult;
        }
        $user = $this->getCurrentUser();
        $nickname = request('nickname');
        $email = request('email');
        $user->nickname = $nickname;
        $user->email = $email;
        $user->save();

        return [
            'msg' => '编辑成功~~~',
            'code' => 0
        ];
    }

    public function viewResetPassword()
    {
        return view('admin/user/resetPassword', ['user' => $this->getCurrentUser()]);
    }

    public function resetPassword(Request $request)
    {
        $validateResult = $this->validateMiddle($request->input(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ], [
            'old_password.required' => '请输入原密码~~~',
            'new_password.required' => '请输入新密码~~~',
            'new_password.min' => '请输入至少六位的新密码~~~',
        ]);
        if ($validateResult) {
            return $validateResult;
        }
        $user = $this->getCurrentUser();
        $old_password = request('old_password');
        $new_password = request('new_password');
        if ($old_password == $new_password) {
            return ajaxReturn('重新输入一个吧，原密码与新密码不能相同~~~');
        }

        if (!$user->verifyPassword($old_password)) {
            return ajaxReturn('请检查原密码是否正确~~~');
        }
        $user->login_pwd = $user->getSaltPassword($new_password);
        $user->save();

        //设置登录的cookie
        $this->setLoginStatus();
        return ajaxReturn('修改成功~~~' );
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
}
