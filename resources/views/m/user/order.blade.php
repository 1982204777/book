@extends('m/layout.main')
@section('js')
	<script src="/js/m/user/order.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;padding-bottom:80px;">
	<div class="page_title clearfix">
    <span>订单列表</span>
</div>
	@foreach($pay_orders as $order)
    <div class="order_box mg-t20">
	<div class="order_header">
		<h2>订单编号: {{$order['order_sn']}}</h2>
		<p>下单时间：{{$order['created_at']}} 状态：{{$pay_status_mapping[$order['status']]}}</p>
				<span class="up_icon"></span>
	</div>
	<ul class="order_list">
		@foreach($order['items'] as $item)
		<li>
			<a href="/m/product/info?id={{$item['book']['id']}}">
				<i class="pic">
                    <img src="{{makeImgUrl($item['book']['main_img'])}}"  style="width: 100px;height: 100px;"/>
                </i>
				<h2>{{$item['book']['name']}} </h2>
				<h3>{!! $item['book']['summary'] !!}</h3>
				<h4>&nbsp;</h4>
				<b>¥ {{$item['book']['price']}}</b>
			</a>
		</li>
			@endforeach
	</ul>
		@if($order['status'])
		<div class="op_box border-top">
            <a style="display: inline-block;" class="button close" data="{{$order['id']}}" href="javascript:void(0);">取消订单</a>
            <a style="display: inline-block;" class="button"  href="/m/product/order/pay?pay_order_id={{$order['id']}}">微信支付</a>
        </div>
			@endif
	</div>
		@endforeach
</div>
@endsection
