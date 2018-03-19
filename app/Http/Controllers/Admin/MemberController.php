<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Member;
use App\Http\Models\MemberComment;
use App\Http\Services\ConstantMapService;
use Illuminate\Http\Request;

class MemberController extends BaseController
{
    public function index(Request $request)
    {
        $input = $request->input();
        $status = array_get($input, 'status', -1);
        $keywords = array_get($input, 'keywords', '');
        $current_page = intval(array_get($input, 'p', 1));
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = Member::query();
        if ($status != -1) {
            $query->where('status', $status);
        }
        if ($keywords) {
            $query->where('nickname', 'like', '%' . $keywords . '%')
                ->orWhere('mobile', 'like', '%' . $keywords .'%');
        }

        $page = config('common.page');
        $page['total_count'] = $query->count();
        $members = $query->orderBy('created_at', 'desc')
                ->offset(($current_page - 1) * $page['page_size'])
                ->limit($page['page_size'])
                ->get();
        $status_mapping = config('common.status_mapping');
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $page['current_page'] = $current_page;

        return view('admin/member/index', compact('members', 'status_mapping', 'page', 'status'));
    }

    public function create()
    {
        return view('admin/member/add');
    }

    public function store(Request $request)
    {
        $validateResult = $this->validateMiddle($request->input(), [
            'nickname' => 'required',
            'mobile' => 'required|min:11',

        ], [
            'nickname.required' => '请输入符合规范的会员名~~~',
            'mobile.required' => '请输入符合规范的会员手机号~~~',
            'mobile.min' => '请输入十一位手机号~~~'
        ]);
        if ($validateResult) {
            return $validateResult;
        }

        $nickname = $request->post('nickname');
        $mobile = $request->post('mobile');
        $model = new Member();
        $model->nickname = $nickname;
        if (!$model::checkUnique($nickname, 'nickname')) {
            return ajaxReturn('该会员名已经被注册了~~~', -1);
        }
        if (!$model::checkUnique($mobile, 'mobile')) {
            return ajaxReturn('一个手机号只能注册一个会员~~~', -1);
        }
        $model->mobile = $mobile;
        $model->avatar = config('common.default_avatar');

        $model->save();

        return ajaxReturn('添加成功~~~');

    }

    public function edit($id)
    {
        $member = Member::find($id);

        return view('admin/member/edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $validateResult = $this->validateMiddle($request->input(), [
            'nickname' => 'required',
            'mobile' => 'required|min:8',

        ], [
            'nickname.required' => '请输入符合规范的会员名~~~',
            'mobile.required' => '请输入符合规范的会员手机号~~~',
        ]);
        if ($validateResult) {
            return $validateResult;
        }
        $member = Member::find($id);
        if (!$member) {
            return ajaxReturn('该会员不存在~~~');
        }
        $nickname = $request->input('nickname');
        $mobile = $request->input('mobile');

        if (!Member::checkUnique($nickname, 'nickname', $member->nickname)) {
            return ajaxReturn('该会员名已经被注册了~~~', -1);
        }
        if (!Member::checkUnique($mobile, 'mobile', $member->mobile)) {
            return ajaxReturn('一个手机号只能注册一个会员~~~', -1);
        }

        $member->nickname = $nickname;
        $member->mobile = $mobile;
        $member->save();

        return ajaxReturn('编辑成功~~~');
    }

    public function show($id)
    {
        $member = Member::where('id', $id)
            ->with('pay_orders')
            ->with('comments')
            ->first();
        $pay_status_mapping = ConstantMapService::$pay_status_mapping;

        return view('admin/member/detail', compact('member', 'pay_status_mapping'));
    }

    public function ops(Request $request)
    {
        $act = $request->post('act');
        $id = $request->post('id');
        if (!$id) {
            return ajaxReturn('请选择要操作的会员~~~');
        }
        if (!in_array($act, ['remove', 'recover'])) {
            return ajaxReturn('操作有误，请重试~~~');
        }
        $member = Member::find($id);
        if (!$member) {
            return ajaxReturn('您指定的会员不存在~~~');
        }
        switch ($act){
            case "remove":
                $member->status = 0;
                $act = '删除成功~~~';
                break;
            case "recover":
                $member->status = 1;
                $act = '恢复成功~~~';
        };
        $member->save();

        return ajaxReturn($act);
    }

    public function comment()
    {
        $current_page = \request()->get('p', 1);
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $page = config('common.page');
        $page['current_page'] = $current_page;
        $query = MemberComment::query();
        $page['total_count'] = $query->count();
        $member_comments = $query->orderBy('created_at', 'desc')
                    ->offset(($current_page - 1) * $page['page_size'])
                    ->take($page['page_size'])
                    ->with('member')
                    ->with('book')
                    ->get();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);

        return view('admin/member/comment/index', compact('member_comments', 'page'));
    }
}
