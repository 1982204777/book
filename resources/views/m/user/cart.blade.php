@extends('m/layout.main')
@section('js')
	<script type="text/javascript" src="/js/m/user/cart.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="order_pro_box">
    	<ul class="order_pro_list">
			@if($carts->isNotEmpty())
			@foreach($carts as $cart)
			<li data-price="{{$cart->book->price}}">
			<a href="/m/product/info?id={{$cart->book->id}}" class="pic" >
                <img src="{{'/storage/' . $cart->book->main_img}}" style="height: 100px;width: 100px;"/>
            </a>
			<h2><a href="/m/product/info?id={{$cart->book->id}}">{{$cart->book->name}}</a></h2>
			<div class="order_c_op">
				<b>¥{{$cart->book->price}}</b>
				<span class="delC_icon" data="{{$cart->id}}" data-book_id="{{$cart->book->id}}"></span>
				<div class="quantity-form">
					<a class="icon_lower" data-book_id="{{$cart->book->id}}" ></a>
					<input type="text" name="quantity" class="input_quantity" value="{{$cart->quantity}}" readonly max="{{$cart->book->stock}}" />
					<a class="icon_plus" data-book_id="{{$cart->book->id}}"></a>
				</div>
			</div>
			</li>
				@endforeach
			@else
				<h4 style="text-align: center;padding-top: 1rem;">购物车空空如也~~~</h4>
			@endif
        	</ul>
    </div>
<div class="cart_fixed">
	<a href="/m/product/order?sc=cart" class="billing_btn">结算</a>
	<b>合计：<strong>¥</strong><font id="price">{{$total_price}}</font></b>
</div></div>
@endsection
