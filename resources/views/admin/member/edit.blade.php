@extends('admin/layout/main')
@section('js')
    <script type="text/javascript" src="/js/web/member/set.js"></script>
@endsection
@section('content')
    <div class="row  border-bottom">
        <div class="col-lg-12">
            <div class="tab_title">
                <ul class="nav nav-pills">
                    <li  class="current"  >
                        <a href="/admin/member">会员列表</a>
                    </li>
                    <li  >
                        <a href="/admin/member/comment">会员评论</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mg-t20 wrap_member_set">
        <div class="col-lg-12">
            <h2 class="text-center">会员设置</h2>
            <div class="form-horizontal m-t">
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">会员名称:</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" placeholder="请输入会员名称" name="nickname" value="{{$member->nickname}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">会员手机:</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" placeholder="请输入会员手机" name="mobile" value="{{$member->mobile}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-lg-4 col-lg-offset-2">
                        <input type="hidden" name="id" value="1">
                        <button class="btn btn-w-m btn-outline btn-primary save" data="{{$member->id}}">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection