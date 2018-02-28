@extends('admin.layout.main')
@section('content')
    <div class="row  border-bottom">
        <div class="col-lg-12">
            <div class="tab_title">
                <ul class="nav nav-pills">
                    <li  class="current"  >
                        <a href="/admin/brand/info">品牌信息</a>
                    </li>
                    <li>
                        <a href="/admin/brand/images">品牌相册</a>
                    </li>
                </ul>
            </div>
        </div>
    </div><div class="row m-t">
        <div class="col-lg-9 col-lg-offset-2 m-t">
            <dl class="dl-horizontal">
                <dt>品牌名称</dt>
                <dd>{{$brand ? $brand->name : ''}}</dd>
                <dt>品牌Logo</dt>
                <dd>
                    <img class="img-circle circle-border" src="{{$brand ? '/storage/' . $brand->logo : ''}}" style="height: 100px;"/>
                </dd>

                <dt>联系电话</dt>
                <dd>{{$brand ? $brand->mobile : ''}}</dd>
                <dt>地址</dt>
                <dd>{{$brand ? $brand->address : ''}}</dd>
                <dt>品牌介绍</dt>
                <dd>{{$brand ? $brand->description : ''}}</dd>
                <dd>
                    <a href="/admin/brand/set" class="btn btn-outline btn-primary btn-w-m">编辑</a>
                </dd>
            </dl>
        </div>
    </div>
@endsection