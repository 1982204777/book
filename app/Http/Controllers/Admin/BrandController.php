<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\BrandImage;
use App\Http\Models\BrandSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

    public function images(Request $request)
    {
        $input = $request->input();
        $current_page = intval(array_get($input, 'p', 1));
        $page = config('common.page');
        $query = BrandImage::query();
        $page['total_count'] = $query->count();
        $brand_images = $query->orderBy('created_at', 'desc')
            ->offset(($current_page - 1) * $page['page_size'])
            ->limit($page['page_size'])
            ->get();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $page['current_page'] = $current_page;

        return view('admin/brand/image', compact('brand_images', 'page'));
    }

    public function image(Request $request)
    {
        $image_key = $request->post('image_key');
        if (!$image_key) {
            return ajaxReturn('请选择需要上传的图片~~~');
        }
        $model = new BrandImage();
        $model->fill([
            'image_key' => $image_key,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $model->save();

        return ajaxReturn('保存成功~~~');
    }

    public function imageOps(Request $request)
    {
        $id = $request->post('id');
        if (!$id) {
            return ajaxReturn('请选择要删除的图片~~~');
        }
        $brand_image = BrandImage::find($id);
        if (!$brand_image) {
            return ajaxReturn('要删除的图片不存在~~~');
        }
        Storage::delete($brand_image->image_key);
        $brand_image->delete();

        return ajaxReturn('删除成功~~~');
    }
}
