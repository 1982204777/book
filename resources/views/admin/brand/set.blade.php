@extends('admin.layout.main')
@section('js')
<script type="text/javascript" src="/js/web/brand/set.js"></script>
@endsection
@section('content')
    <div class="row  border-bottom">
        <div class="col-lg-12">
            <div class="tab_title">
                <ul class="nav nav-pills">
                    <li  class="current"  >
                        <a href="/admin/brand/info">品牌信息</a>
                    </li>
                    <li  >
                        <a href="/admin/brand/images">品牌相册</a>
                    </li>
                </ul>
            </div>
        </div>
    </div><div class="row m-t  wrap_brand_set">
        <div class="col-lg-12">
            <h2 class="text-center">品牌设置</h2>
            <div class="form-horizontal m-t m-b">
                <div class="form-group">
                    <label class="col-lg-2 control-label">品牌名称:</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control" placeholder="请输入品牌名称~~" value="{{$brand ? $brand->name : ''}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">品牌Logo:</label>
                    <div class="col-lg-10">
                        <form class="upload_pic_wrap" target="upload_file" enctype="multipart/form-data" method="POST" action="/admin/upload/pic">
                            {{csrf_field()}}
                            <div class="upload_wrap pull-left">
                                <i class="fa fa-upload fa-2x"></i>
                                <input type="hidden" name="bucket" value="brand" />
                                <input class="preview_input" type="file" name="pic" accept="image/png, image/jpeg, image/jpg,image/gif">
                            </div>
                            <div class="pic-each">
                            <img class="preview_img" src="{{$brand ? $brand->logo : ''}}">
                                {{--<span class="fa fa-times-circle del del_image hidden"><i></i></span>--}}
                                <div class="hidden image_key">
                                    <span data=""></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">电话:</label>
                    <div class="col-lg-10">
                        <input type="text" name="mobile" class="form-control" placeholder="请输入联系电话~~"  value="{{$brand ? $brand->mobile : ''}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">地址:</label>
                    <div class="col-lg-10">
                        <input type="text" name="address" class="form-control" placeholder="请输入联系地址~~"  value="{{$brand ? $brand->address : ''}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">品牌介绍:</label>
                    <div class="col-lg-10">
                        <textarea  name="description" class="form-control" rows="4">{{$brand ? $brand->description : ''}}</textarea>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe name="upload_file" class="hide"></iframe>
@endsection