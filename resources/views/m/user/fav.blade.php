@extends('m/layout.main')
@section('js')
	<script type="text/javascript" src="/js/m/user/fav.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="page_title clearfix">
		<span>我的收藏</span>
	</div>
	<ul class="fav_list">
		@if($favs->isNotEmpty())
		@foreach($favs as $fav)
		<li>
		<a href="/m/product/info?id={{$fav->book->id}}">
			<i class="pic"><img src="{{'/storage/' . $fav->book->main_img}}" style="height: 100px;width: 100px; padding-top:10px;" /></i>
			<h2>{{$fav->book->name}}</h2>
			<b>¥ {{$fav->book->price}}</b>
		</a>
		<span class="del_fav" data="{{$fav->id}}"><i class="del_fav_icon"></i></span>
		</li>
			@endforeach
		@else
			<h4 style="text-align: center;padding-top: 1rem;">啥都没有，你瞅啥~~~</h4>
		@endif
	</ul>
</div>
@endsection