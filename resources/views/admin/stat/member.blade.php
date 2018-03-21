@extends('admin.layout.main')
@section('js')
	<link href="/plugins/datetimepicker/jquery.datetimepicker.min.css" rel="stylesheet"></head>
	<script type="text/javascript" src="/plugins/highcharts/highcharts.js"></script>
	<script type="text/javascript" src="/plugins/datetimepicker/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript" src="/js/web/chart.js"></script>
	<script type="text/javascript" src="/js/web/stat/member.js"></script>
@endsection
@section('content')
	<div class="row  border-bottom">
		<div class="col-lg-12">
			<div class="tab_title">
				<ul class="nav nav-pills">
					<li>
						<a href="/admin/stat">财务统计</a>
					</li>
					<li  >
						<a href="/admin/stat/product">商品售卖</a>
					</li>
					<li class="current">
						<a href="/admin/stat/member">会员消费统计</a>
					</li>
					<li  >
						<a href="/admin/stat/share">分享统计</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row m-t">
	<div class="col-lg-12 m-t">
		<form class="form-inline" id="search_form_wrap">
			<div class="row p-w-m">
				<div class="form-group">
					<div class="input-group">
						<input type="text" placeholder="请选择开始时间" name="date_from" class="form-control"  value="{{$search_conditions['date_from']}}">
					</div>
				</div>
				<div class="form-group m-r m-l">
					<label>至</label>
				</div>
				<div class="form-group">
					<div class="input-group">
						<input type="text" placeholder="请选择结束时间" name="date_to" class="form-control" value="{{$search_conditions['date_to']}}">
					</div>
				</div>
				<div class="form-group">
					<a class="btn btn-w-m btn-outline btn-primary search">搜索</a>
				</div>
			</div>
			<hr/>
		</form>
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>日期</th>
				<th>会员名称</th>
				<th>会员手机</th>
				<th>消费总额</th>
				<th>分享次数</th>
			</tr>
			</thead>
			<tbody>
			@foreach($list as $item)
			<tr>
				<td>{{$item['date']}}</td>
				<td>
					{{$item['member']['nickname']}}
				</td>
				<td>
					{{$item['member']['mobile']}}
				</td>
				<td>{{$item['total_pay_money']}}</td>
				<td>{{$item['total_shared_count']}}</td>
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
							<li><a href="/admin/stat/member?p={{$p}}">{{$p}}</a></li>
						@endif
					@endfor
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection
