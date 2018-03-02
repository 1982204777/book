@extends('m/layout.main')
@section('js')

@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="mem_info">
	<span class="m_pic"><img src="{{$user->avatar}}" /></span>
	<p>{{$user->nickname}}</p>
</div>
<div class="fastway_list_box">
	<ul class="fastway_list">
		<li><a href="/m/user/cart"><b class="wl_icon"></b><i class="right_icon"></i><span>购物车</span></a></li>
		<li><a href="/m/user/order"><b class="morder_icon"></b><i class="right_icon"></i><span>我的订单</span></a></li>
		<li><a href="/m/user/fav"><b class="fav_icon"></b><i class="right_icon"></i><span>我的收藏</span></a></li>
		<li><a href="/m/user/comment"><b class="sales_icon"></b><i class="right_icon"></i><span>我的评论</span></a></li>
		<li><a href="/m/user/address"><b class="locate_icon"></b><i class="right_icon"></i><span>收货地址</span></a></li>
	</ul>
</div>

</div>
@endsection
