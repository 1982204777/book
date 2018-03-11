@extends('m/layout.main')
@section('js')
	<script type="text/javascript" src="/js/m/product/order.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="page_title clearfix">
    <span>订单提交</span>
</div>
<div class="order_box">
    <div class="order_header">
        <h2>确认收货地址</h2>
    </div>

    <ul class="address_list">
		@if($address_list)
        @foreach($address_list as $address)
        <li style="padding: 5px 5px;">
            <label>
                <input style="display: inline;" type="radio" name="address_id" value="{{$address['id']}}"  {{$address['is_default'] ? 'checked' : ''}}   >
                {{$address['address']}}（{{$address['name']}}收）{{$address['mobile']}}                </label>
        </li>
        @endforeach
		@else
			<li style="padding: 5px 5px;">
				<a href="/m/user/address/create">快去添加收货地址啦~~~</a>
			</li>
		@endif
    </ul>


	<div class="order_header">
		<h2>确认订单信息</h2>
	</div>
		<ul class="order_list">
			@foreach($product_list as $product)
			<li data="{{$product['id']}}" data-quantity="{{$product['quantity']}}">
			<a href="/m/product/info?id={{$product['id']}}">
				<i class="pic">
					<img src="{{makeImgUrl($product['main_img'])}}" style="width: 100px;height: 100px;"/>
				</i>
				<h2>{{$product['name']}} x {{$product['quantity']}}</h2>
				<h4>&nbsp;</h4>
				<b>¥ {{$product['price']}}</b>
			</a>
		</li>
				@endforeach
			</ul>
		<div class="order_header" style="border-top: 1px dashed #ccc;">
		<h2>总计：{{$total_price}}</h2>
	</div>
</div>
<div class="op_box">
    <input type="hidden" name="sc" value="product">
	<input style="width: 100%;" type="button" value="确定下单" class="red_btn do_order"  />
</div>
</div>
@endsection
