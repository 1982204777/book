@extends('admin.layout.main')
@section('js')
	<script type="text/javascript" src="/js/web/bookCategory/index.js"></script>
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
<div class="row">
	<div class="col-lg-12">
		<form class="form-inline wrap_search">
			<div class="row  m-t p-w-m">
				<div class="form-group">
					<select name="status" class="form-control inline">
						<option value="-1">请选择状态</option>
						@foreach($status_mapping as $key => $status)
							<option value="{{$key}}" {{request()->get('status') == $key ? 'selected' : ''}}>{{$status}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-lg-12">
					<a class="btn btn-w-m btn-outline btn-primary pull-right" href="/admin/book/category/create">
						<i class="fa fa-plus"></i>分类
					</a>
				</div>
			</div>

		</form>
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>序号</th>
				<th>分类名称</th>
				<th>状态</th>
				<th>权重</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
			@foreach($categories as $category)
				<tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
					<td>{{$status_mapping[$category->status]}}</td>
                    <td>{{$category->weight}}</td>
                    <td>
						@if($category->status == 1)
							<a class="m-l" href="/admin/book/category/{{$category->id}}/edit">
								<i class="fa fa-edit fa-lg"></i>
							</a>
							<a class="m-l remove" href="javascript:void(0);" data="{{$category->id}}">
								<i class="fa fa-trash fa-lg"></i>
							</a>
						@else
							<a class="m-l recover" href="javascript:void(0);" data="{{$category->id}}">
								<i class="fa fa-rotate-left fa-lg"></i>
							</a>
						@endif
					</td>
                </tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
