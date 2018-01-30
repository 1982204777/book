@extends('admin/layout/main')
@section('js')
    <script type="text/javascript" src="/js/web/member/index.js"></script>
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
                        <a href="/web/member/comment">会员评论</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form class="form-inline wrap_search">
                <div class="row  m-t p-w-m">
                    <div class="form-group">
                        <select name="status" class="form-control inline">
                            <option value="-1">请选择状态</option>
                            @foreach($status_mapping as $key => $status_item)
                            <option value="{{$key}}" {{$status == $key ? 'selected' : ''}}>{{$status_item}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="keywords" placeholder="请输入关键字" class="form-control" value="{{request('keywords')}}">
                            <span class="input-group-btn">
                        <button type="button" class="btn  btn-primary search">
                            <i class="fa fa-search"></i>搜索
                        </button>
                    </span>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/admin/member/create">
                            <i class="fa fa-plus"></i>会员
                        </a>
                    </div>
                </div>

            </form>
            <table class="table table-bordered m-t">
                <thead>
                <tr>
                    <th>头像</th>
                    <th>姓名</th>
                    <th>手机</th>
                    <th>性别</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                <tr>
                    <td><img alt="image" class="img-circle" src="{{$member->avatar}}" style="width: 40px;height: 40px;"></td>
                    <td>{{$member->nickname}}</td>
                    <td>{{$member->mobile}}</td>
                    <td>
                        @if($member->sex == 1)
                            男
                            @elseif($member->sex == 2)
                            女
                        @else
                            未填写
                        @endif
                    </td>
                    <td>
                        @foreach($status_mapping as $key => $status_item)
                            @if($member->status == $key)
                                {{$status_item}}
                            @endif
                            @endforeach
                    </td>
                    <td>
                        <a  href="/admin/member/{{$member->id}}">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                        <a class="m-l" href="/admin/member/{{$member->id}}/edit">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                        @if($member->status == 1)
                        <a class="m-l remove" href="javascript:void(0);" data="{{$member->id}}">
                            <i class="fa fa-trash fa-lg"></i>
                        </a>
                        @else
                        <a class="m-l recover" href="javascript:void(0);" data="{{$member->id}}">
                            <i class="fa fa-rotate-left fa-lg"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-12">
                    <span class="pagination_count" style="line-height: 40px;">共{{$page['total_count']}}条记录 | 每页{{$page['page_size']}}条</span>
                    <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                        @for($p = 1;$p <= $page['page_count']; $p++)
                            @if($p == $page['current_page'])
                                <li class="active"><span>{{$p}}</span></li>
                            @else
                                <li><a href="/admin/member?p={{$p}}">{{$p}}</a></li>
                            @endif
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection