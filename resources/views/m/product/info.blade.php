@extends('m/layout.main')
@section('js')
    <script type="text/javascript" src="/js/m/product/info.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="pro_tab clearfix">
    <span>图书详情</span>
</div>
<div class="proban">
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                <li><img src="{{'/storage/' . $book->main_img}}"/></li>
            </ul>
        </div>
    </div>
</div>
<div class="pro_header">
    <div class="pro_tips">
        <h2>{{$book->name}}</h2>
        <h3><b>¥{{$book->price}}</b><font>库存量：{{$book->stock}}</font></h3>
    </div>
    <span class="share_span"><i class="share_icon"></i><b>分享商品</b></span>
</div>
<div class="pro_express">月销量：{{$book->month_count}}<b>累计评价：{{$book->comment_count}}</b></div>
<div class="pro_virtue">
    <div class="pro_vlist">
        <b>数量</b>
        <div class="quantity-form">
            <a class="icon_lower"></a>
            <input type="text" name="quantity" class="input_quantity" max="{{$book->stock}}" value="1"/>
            <a class="icon_plus"></a>
        </div>
    </div>
</div>
<div class="pro_warp">
	<p>
        <span style="color: rgb(101, 101, 101); font-family: &quot;Hiragino Sans GB&quot;, Verdana, Simsun; font-size: 14px; background-color: rgb(255, 255, 255);">
            {!! $book->summary !!}
        </span>
    </p>
</div>
<div class="pro_fixed clearfix">
    <a href="/m/home"><i class="sto_icon"></i><span>首页</span></a>
            <a class="{{isset($member_fav) ? 'has_faved' : 'fav'}}" href="javascript:void(0);" data="{{$book->id}}"><i class="keep_icon"></i>
                <span>{{isset($member_fav) ? '已收藏' : '收藏'}}</span>
            </a>
        <input type="button" value="立即订购" class="order_now_btn" data="{{$book->id}}"/>
    <input type="button" value="加入购物车" class="add_cart_btn" data="{{$book->id}}"/>
    <input type="hidden" name="id" value="{{$book->id}}">
</div>
</div>
@endsection
