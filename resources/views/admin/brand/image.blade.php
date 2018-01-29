@extends('admin.layout.main')
@section('js')
    <script type="text/javascript" src="/js/web/brand/image.js"></script>
@endsection
@section('content')
    <div class="row  border-bottom">
        <div class="col-lg-12">
            <div class="tab_title">
                <ul class="nav nav-pills">
                    <li  >
                        <a href="/admin/brand/info">品牌信息</a>
                    </li>
                    <li  class="current"  >
                        <a href="/admin/brand/images">品牌相册</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row m-t">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right set_pic" href="javascript:void(0);">
                        <i class="fa fa-plus"></i>图片
                    </a>
                </div>
            </div>
            <table class="table table-bordered m-t">
                <thead>
                <tr>
                    <th>图片（16:9）</th>
                    <th>大图地址</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brand_images as $image)
                <tr>
                    <td>
                        <img src="{{$image->image_key}}" style="height: 100px;"/>
                    </td>
                    <td>
                        <a target="_blank" href="{{$image->image_key}}">查看大图</a>
                    </td>
                    <td>
                        <a class="m-l remove" href="javascript:void(0);" data="{{$image->id}}">
                            <i class="fa fa-trash fa-lg"></i>
                        </a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <span class="pagination_count" style="line-height: 40px;">共{{$page['total_count']}}条记录 | 每页{{$page['page_size']}}条</span>
            <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                @for($p = 1;$p <= $page['page_count']; $p++)
                    @if($p == $page['current_page'])
                        <li class="active"><a href="/admin/brand/images?p={{$p}}">{{$p}}</a></li>
                    @else
                        <li><a href="/admin/brand/images?p={{$p}}">{{$p}}</a></li>
                    @endif
                @endfor
            </ul>
        </div>
    </div>
    <div class="modal fade" id="brand_image_wrap" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">上传图片</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <form class="upload_pic_wrap" target="upload_file" enctype="multipart/form-data" method="POST" action="/admin/upload/pic">
                                {{csrf_field()}}
                                <div class="upload_wrap pull-left">
                                    <i class="fa fa-upload fa-2x"></i>
                                    <input type="hidden" name="bucket" value="brand" />
                                    <input class="preview_input" type="file" name="pic" accept="image/png, image/jpeg, image/jpg,image/gif">
                                </div>
                                <div class="pic-each">
                                    <img class="preview_img" src="{{isset($brand) ? $brand->logo : ''}}">
                                    <div class="hidden image_key">
                                        <span data="{{isset($brand) ? $brand->logo : ''}}"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary save">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <iframe name="upload_file" class="hide"></iframe>

@endsection