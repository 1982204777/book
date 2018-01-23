@extends('admin.layout.main')
@section('js')
    <script type="text/javascript" src="/js/web/account/index.js"></script>
@endsection
@section('content')
    <div class="row  border-bottom">
        <div class="col-lg-12">
            <div class="tab_title">
                <ul class="nav nav-pills">
                    <li  class="current"  >
                        <a href="/admin/account">账户列表</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form class="form-inline wrap_search">
                <div class="row m-t p-w-m">
                    <div class="form-group">
                        <select name="status" class="form-control inline">
                            <option value="{{config('common.status_default')}}">请选择状态</option>
                            @foreach($status_mapping as $key => $status_item)
                            <option value="{{$key}}" {{$status == $key ? 'selected' : ''}}>{{$status_item}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="keywords" placeholder="请输入姓名或者手机号码" class="form-control" value="{{request('keywords')}}">
                            <input type="hidden" name="p" value="1">
                            <span class="input-group-btn">
                        <button type="button" class="btn btn-primary search">
                            <i class="fa fa-search"></i>搜索
                        </button>
                    </span>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/admin/account/create">
                            <i class="fa fa-plus"></i>账号
                        </a>
                    </div>
                </div>
            </form>
            <table class="table table-bordered m-t">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>手机</th>
                    <th>邮箱</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                <tr>
                    <td>{{$account->uid}}</td>
                    <td>{{$account->nickname}}</td>
                    <td>{{$account->mobile}}</td>
                    <td>{{$account->email}}</td>
                    <td>
                        <a  href="/admin/account/{{$account->uid}}">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                        <a class="m-l" href="/admin/account/{{$account->uid}}/edit">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>

                        <a class="m-l remove" href="javascript:void(0);" data="13">
                            <i class="fa fa-trash fa-lg"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-12">
                    <span class="pagination_count" style="line-height: 40px;">共{{$page['total_count']}}条记录 | 每页{{$page['page_size']}}条</span>
                    <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                    @for($p = 1;$p <= $page['total_count']; $p++)
                        @if($p == $page['current_page'])
                                <li class="active"><a href="/admin/account?p={{$p}}">{{$p}}</a></li>
                            @else
                                <li><a href="/admin/account?p={{$p}}">{{$p}}</a></li>
                            @endif
                    @endfor
                    </ul>
                </div>
{{--                {{$accounts->links()}}--}}
            </div>
        </div>
    </div>
@endsection