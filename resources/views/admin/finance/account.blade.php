@extends('admin.layout.main')
@section('js')
@endsection
@section('content')
	<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
								<li  >
					<a href="/admin/finance">订单列表</a>
				</li>
								<li  class="current"  >
					<a href="/admin/finance/account">财务流水</a>
				</li>
							</ul>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-12 m-t">
        <p>总收款金额：{{$total_count}}元</p>
    </div>
	<div class="col-lg-12">
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>订单编号</th>
				<th>第三方流水号</th>
				<th>支付金额</th>
				<th>支付时间</th>
			</tr>
			</thead>
			<tbody>
			@foreach($pay_orders as $order)
			<tr>
				<td>{{$order->order_sn}}</td>
				<td>{{$order->pay_sn}}</td>
				<td>{{$order->pay_price}}</td>
				<td>{{$order->pay_time}}</td>
			</tr>
			</tbody>
			@endforeach
		</table>
		<div class="row">
			<div class="col-lg-12">
				<span class="pagination_count" style="line-height: 40px;">共{{$page['total_count']}}条记录 | 每页{{$page['page_size']}}条</span>
				<ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
					@for($p = 1;$p <= $page['page_count']; $p++)
						@if($p == $page['current_page'])
							<li class="active"><span>{{$p}}</span></li>
						@else
							<li><a href="/admin/finance/account?p={{$p}}">{{$p}}</a></li>
						@endif
					@endfor
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection