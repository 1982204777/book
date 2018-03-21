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
		@if( $order['status'] == 1)
		<p>快递状态：{{$express_status_mapping[$order['express_status']]}}</p>
		@if($order['express_info'])
		<p>快递信息：{{$order['express_info']}}</p>
			@endif
        @endif
				<span class="up_icon"></span>
	</div>
	<ul class="order_list">
		@foreach($order['items'] as $item)
		<li>
			<a href="/m/product/info?id={{$item['book']['id']}}">
				<i class="pic">
                    <img src="{{makeImgUrl($item['book']['main_img'])}}"  style="width: 100px;height: 100px;"/>
                </i>
				<h2 style="margin-top:10px;">{{$item['book']['name']}} </h2>
				<span>x{{$item['quantity']}}</span>
				<div style="margin-top: 20px; overflow: hidden;"></div>
				<span class="left">¥ {{$item['book']['price']}}</span><span style="float: right;">x{{$item['quantity']}}</span>
			</a>
			@if($order['status'] == 1 && $order['express_status'] == 1 && !$item['comment_status'])
				<a style="display: block;position: absolute;bottom: 1rem;right: 1rem;" class="button" href="/m/product/order/comment/create?pay_order_id={{$order['id']	}}&book_id={{$item['book']['id']}}">我要评论</a>
			@endif
			@if($order['status'] == 1 && $order['express_status'] == -6)
					<a style="display: block;position: absolute;bottom: 1rem;right: 1rem;" class="button confirm-express" data="{{$order['id']}}"  href="#"  class="button confirm_express">确认收货</a>
			@endif
		</li>
			@endforeach
	</ul>
		@if($order['status'] == -8)
		<div class="op_box border-top">
			<span style="margin-right: 20px;">总计：{{$order['pay_price']}}</span>
            <a style="display: inline-block;" class="button close" data="{{$order['id']}}" href="javascript:void(0);">取消订单</a>
            <a style="display: inline-block;" class="button"  href="/m/product/order/pay?pay_order_id={{$order['id']}}">微信支付</a>
        </div>
		@endif

	</div>
		@endforeach
</div>
@endsection
