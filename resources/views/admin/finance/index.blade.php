@extends('admin.layout.main')
@section('js')
	<script type="text/javascript" src="/js/web/finance/index.js"></script>
@endsection
@section('content')
		<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
								<li  class="current"  >
					<a href="/admin/finance">订单列表</a>
				</li>
								<li  >
					<a href="/admin/finance/account">财务流水</a>
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
						@foreach($pay_status_mapping as $key => $item)
							<option value="{{$key}}"  {{$search_conditions['status'] == $key ? 'selected' : ''}}>{{$item}}</option>
							@endforeach
					</select>
				</div>
			</div>
		</form>
		<hr/>
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>订单编号</th>
				<th>名称</th>
				<th>价格</th>
				<th>支付时间</th>
				<th>状态</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
			@foreach($pay_order_list as $item)
			<tr>
				<td>{{$item['order_sn']}}</td>
				<td>
					@foreach($item['items'] as $item1)
					{{$item1['name']}} × {{$item1['quantity']}}<br/>
					@endforeach
				</td>
				<td>{{$item['pay_price']}}</td>
				<td>{{$item['pay_time']}}</td>
				<td>{{$pay_status_mapping[$item['status']]}}</td>
				<td>{{$item['created_at']}}</td>
				<td>
					<a  href="/admin/finance/{{$item['id']}}">
						<i class="fa fa-eye fa-lg"></i>
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
				@for($p = 1;$p <= $page['page_count']; $p++)
					@if($p == $page['current_page'])
						<li class="active"><span>{{$p}}</span></li>
					@else
						<li><a href="/admin/finance?p={{$p}}">{{$p}}</a></li>
					@endif
				@endfor
			</ul>
		</div>
	</div>
	</div>
</div>
@endsection