<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends BaseController
{

    protected $allow_file_type = ['jpg', 'gif', 'png', 'jpeg'];

    /**
     * 上传接口
     * bucket: avatar/brand/book
     */
    public function uploadImage()
    {
        $bucket = request('bucket');
        $callback = "window.parent.upload";//error success

        if (!$_FILES || !isset($_FILES['pic'])) {
            return "<script>{$callback}.error('请选择文件后再进行上传~~~')</script>";
        }
        if ($_FILES['pic']['error'] == 1) {
            return "<script>{$callback}.error('图片过大，请选择低于2mb的图片~~~')</script>";
        }
        $file_name = $_FILES['pic']['name'];
        $tmp_file_extend = explode('.', $file_name);
        if (!in_array(strtolower(end($tmp_file_extend)), $this->allow_file_type)) {
            return "<script>{$callback}.error('请选择指定类型图片上传，允许上传图片类型：jpg,gif,png,jpeg~~~')</script>";
        }

        //上传图片业务
        $path = request()->file('pic')->storePublicly($bucket . '/' . date('Ymd'));
        $file_path = asset('storage/' . $path);

        return "<script>{$callback}.success('{$file_path}')</script>";
    }
}
