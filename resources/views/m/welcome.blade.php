@extends('m/layout.main')
@section('js')
    <script type="text/javascript" src="/js/m/welcome/TouchSlide.1.1.js"></script>
    <script type="text/javascript" src="/js/m/welcome/index.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
    {{--<div class="shop_header">--}}
        {{--<i class="shop_icon"></i>--}}
        {{--<strong>编程浪子的博客</strong>--}}
    {{--</div>--}}


    @if(count($brand_images) > 0)
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                @foreach($brand_images as $image)
                <li><img style="max-height: 250px;" src="{{'/storage/' . $image->image_key}}" /></li>
                @endforeach
            </ul>
        </div>
        <div class="hd"><ul></ul></div>
    </div>
    @endif
    <div class="fastway_list_box">
        <ul class="fastway_list">
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>品牌名称：{{$brand_info->name}}</span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>联系电话：{{$brand_info->mobile}}</span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>联系地址：{{$brand_info->address}}</span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>品牌介绍：{{$brand_info->description}}</span></a></li>
        </ul>
    </div></div>
<div class="copyright clearfix">
    @if(isset($user))
        <p class="name">欢迎您，{{$user->nickname}}</p>
    @endif
    <p class="copyright">由<a href="/" target="_blank">王庆銮</a>提供技术支持</p>
</div>
@endsection
