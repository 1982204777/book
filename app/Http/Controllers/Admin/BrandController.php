<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\BrandSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends BaseController
{
    public function set()
    {
        $brand = BrandSetting::first();
        return view('admin/brand/set', compact('brand'));
    }

    public function doSet(Request $request)
    {
        $validateResult = $this->validateMiddle($request->input(), [
            'name' => 'required',
            'image_key' => 'required',
            'mobile' => 'required|min:8',
            'address' => 'required',
            'description' => 'required',
        ], [
            'name.required' => '请输入符合规范的品牌名~~~',
            'image_key.required' => '请上传品牌logo~~~',
            'mobile.required' => '请输入符合规范的联系电话~~~',
            'mobile.min' => '请输入符合规范的联系电话~~~',
            'address.email' => '请输入符合规范的地址~~~',
            'description.required' => '请输符合规范的品牌介绍~~~',
        ]);
        if ($validateResult) {
            return $validateResult;
        }
        $brand = BrandSetting::first();
        if ($brand) {
            $brand_model = $brand;
        } else {
            $brand_model = new BrandSetting();
        }
        $input = request(['name', 'mobile', 'address', 'description']);
        $input['logo'] = request('image_key');
        $brand_model->fill($input);
        $brand_model->save();

        return ajaxReturn('编辑成功~~~');
    }

    public function info()
    {
        $brand = BrandSetting::first();

        return view('admin/brand/info', compact('brand'));
    }

    public function images()
    {
        return view('admin/brand/image');
    }
}
