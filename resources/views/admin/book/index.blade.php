@extends('admin.layout.main')
@section('js')
    <script type="text/javascript" src="/js/web/book/index.js"></script>
@endsection
@section('content')
<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
            <ul class="nav nav-pills">
                <li  class="current"  >
                    <a href="/admin/book">图书列表</a>
                </li>
                <li  >
                    <a href="/admin/book/category">分类列表</a>
                </li>
                <li  >
                    <a href="/admin/book/images">图片资源</a>
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
                            <option value="{{$key}}" {{$status == $key ? 'selected' : ''}} >{{$status_item}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="cat_id" class="form-control inline">
                        <option value="0">请选择分类</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$cat_id == $category->id ? 'selected' : ''}} >{{$category->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入关键字" class="form-control" value="{{request()->get('mix_kw')}}">
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
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="book/create">
                        <i class="fa fa-plus"></i>图书
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>图书名</th>
                <th>分类</th>
                <th>价格</th>
                <th>库存</th>
                <th>标签</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{$book->name}}</td>
                <td>{{$book->category->name}}</td>
                <td>{{$book->price}}</td>
                <td>{{$book->stock}}</td>
                <td>{{$book->tags}}</td>
                <td>
                    <a  href="/admin/book/{{$book->id}}">
                        <i class="fa fa-eye fa-lg"></i>
                    </a>
                    @if($book->status == 1)
                        <a class="m-l" href="/admin/book/{{$book->id}}/edit">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                        <a class="m-l remove" href="javascript:void(0);" data="{{$book->id}}">
                            <i class="fa fa-trash fa-lg"></i>
                        </a>
                    @else
                        <a class="m-l recover" href="javascript:void(0);" data="{{$book->id}}">
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
                            <li><a href="/admin/book?p={{$p}}">{{$p}}</a></li>
                        @endif
                    @endfor
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection