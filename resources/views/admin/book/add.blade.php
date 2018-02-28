@extends('admin.layout.main')
@section('js')
    <script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/plugins/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

    <link href="/plugins/tagsinput/jquery.tagsinput.min.css" rel="stylesheet">
    <script type="text/javascript" src="/plugins/tagsinput/jquery.tagsinput.min.js"></script>

    <link href="/plugins/select2/select2.min.css" rel="stylesheet">
    <script type="text/javascript" src="/plugins/select2/select2.pinyin.js"></script>
    <script type="text/javascript" src="/plugins/select2/zh-CN.js"></script>
    <script type="text/javascript" src="/plugins/select2/pinyin.core.js"></script>
    <script type="text/javascript" src="/js/web/book/set.js"></script>
@endsection
@section('content')
    <div class="row  border-bottom">
        <div class="col-lg-12">
            <div class="tab_title">
                <ul class="nav nav-pills">
                    <li  >
                        <a href="/admin/book">图书列表</a>
                    </li>
                    <li  class="current"  >
                        <a href="/admin/book/category">分类列表</a>
                    </li>
                    <li  >
                        <a href="/admin/book/images">图片资源</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">图书设置</h2>
        <div class="form-horizontal m-t">
            <div class="form-group">
                <label class="col-lg-2 control-label">图书分类:</label>
                <div class="col-lg-10">
                    <select name="cat_id" class="form-control">
                        <option value="0">请选择分类</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书名称:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入图书名" name="name" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书价格:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入图书售价" name="price" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">封面图:</label>
                <div class="col-lg-10">
                    <form class="upload_pic_wrap" target="upload_file" enctype="multipart/form-data" method="POST" action="/admin/upload/pic">
                        {{csrf_field()}}
                        <div class="upload_wrap pull-left">
                            <i class="fa fa-upload fa-2x"></i>
                            <input type="hidden" name="bucket" value="book" />
                            <input class="preview_input" type="file" name="pic" accept="image/png, image/jpeg, image/jpg,image/gif">
                        </div>
                        <div class="pic-each">
                            <img class="preview_img" src="">
                            <div class="hidden image_key">
                                <span data=""></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书描述:</label>
                <div class="col-lg-8">
                    <textarea   id="editor"  name="summary" style="height: 300px;"></textarea>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">库存:</label>
                <div class="col-lg-2">
                    <div class="input-group">
                        <div class="input-group-addon hidden">
                            <a class="disabled" href="javascript:void(0);">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                        <input type="text" name="stock" class="form-control" value="1">
                        <div class="input-group-addon hidden">
                            <a href="javascript:void(0);">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书标签:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="tags" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                    <input type="hidden" name="id" value="0">
                    <button class="btn btn-w-m btn-outline btn-primary save" data="create">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <iframe name="upload_file" class="hide"></iframe>
@endsection
