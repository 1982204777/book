<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Models\MemberAddress;
use App\Http\Services\AreaService;
use App\Http\Services\ConstantMapService;
use Illuminate\Http\Request;

class AddressController extends BaseController
{
    public function index()
    {
        $member = \request()->attributes->get('member');
        $member_addresses = MemberAddress::where('member_id', $member->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('m/user/address/index', compact('member_addresses'));
    }

    public function create()
    {
        return view('m/user/address/add', [
            'province_mapping' => AreaService::getProvinceMapping()
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $validate = $this->validateMiddle($input, [
            'nickname' => 'required',
            'mobile' => 'regex:/^1[34578][0-9]{9}$/',
            'province_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'address' => 'required|min:3'
        ], [
            'nickname.required' => '请输入收货人姓名~~~',
            'mobile.regex' => '请输入符合规范的收货人联系电话~~~',
            'province_id.required' => '请选择省份~~~',
            'city_id.required' => '请选择城市~~~',
            'area_id.required' => '请选择区~~~',
            'address.required' => '请输入符合规范的地址~~~',
            'address.min' => '请输入符合规范的地址~~~'
        ]);
        if ($validate) {
            return ajaxReturn($validate);
        }
        $member = $request->attributes->get('member');
        $query = MemberAddress::query();
        if ($query->where('member_id', $member->id)->where('status', 1)->count()) {
            $member_addresses = $query->get();
            foreach ($member_addresses as $address) {
                $address->is_default = 0;
                $address->save();
            }
        }
        $member_address = new MemberAddress();
        $member_address->member_id = $member->id;
        $member_address->nickname = $input['nickname'];
        $member_address->mobile = $input['mobile'];
        $member_address->province_id = $input['province_id'];
        $member_address->city_id = $input['city_id'];
        $member_address->area_id = $input['area_id'];
        $member_address->address = $input['address'];
        if ($member_address->save()) {
            return ajaxReturn('添加成功~~~');
        } else {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
    }

    public function edit($id)
    {
        $member_address = MemberAddress::find($id);
        $province_mapping = AreaService::getProvinceMapping();

        return view('m/user/address/edit', compact('member_address', 'province_mapping'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->except('_token');
        $validate = $this->validateMiddle($input, [
            'nickname' => 'required',
            'mobile' => 'regex:/^1[34578][0-9]{9}$/',
            'province_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'address' => 'required|min:3'
        ], [
            'nickname.required' => '请输入收货人姓名~~~',
            'mobile.regex' => '请输入符合规范的收货人联系电话~~~',
            'province_id.required' => '请选择省份~~~',
            'city_id.required' => '请选择城市~~~',
            'area_id.required' => '请选择区~~~',
            'address.required' => '请输入符合规范的地址~~~',
            'address.min' => '请输入符合规范的地址~~~'
        ]);
        if ($validate) {
            return ajaxReturn($validate);
        }
        $member_address = MemberAddress::find($id);
        if (!$member_address) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
        $member = $request->attributes->get('member');
        $member_address->member_id = $member->id;
        $member_address->nickname = $input['nickname'];
        $member_address->mobile = $input['mobile'];
        $member_address->province_id = $input['province_id'];
        $member_address->city_id = $input['city_id'];
        $member_address->area_id = $input['area_id'];
        $member_address->address = $input['address'];
        if (!$member_address->save()) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }

        return ajaxReturn('操作成功~~~');
    }

    public function getProvinceCityTree(Request $request)
    {
        $province_id = $request->post('province_id');
        $tree_info = AreaService::getProvinceCityTree($province_id);

        return ajaxReturn($tree_info);
    }

    public function ops(Request $request)
    {
        $id = $request->post('id', '');
        $act = $request->post('act');
        if (!$id) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
        if (!in_array($act, ['set_default', 'del'])) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
        $member_address = MemberAddress::find($id);
        if (!$member_address) {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
        switch ($act) {
            case 'set_default':
                $query = MemberAddress::query();
                $is_default_count = $query->where('member_id', $member_address->member_id)
                    ->where('status', 1)
                    ->whereNotIn('id', [$member_address->id])
                    ->count();
                if ($is_default_count) {
                    $member_addresses = $query->get();
                    foreach ($member_addresses as $address) {
                        $address->is_default = 0;
                        $address->save();
                    }
                }
                if ($member_address->is_default == 1) {
                    $code = 2;
                } else {
                    $member_address->is_default = 1;
                }
                $act = '操作成功~~~';
                break;
            case 'del':
                $member_address->status = 0;
                $act = '删除成功~~~';
                break;
        }
        if ($member_address->save()) {
            return ajaxReturn($act, isset($code) ? $code : 0);
        } else {
            return ajaxReturn(ConstantMapService::$default_system_err, -1);
        }
    }
}
