@extends('m/layout.main')
@section('js')
    <script src="/plugins/raty/jquery.raty.min.js"></script>
    <script src="/js/m/user/comment.js"></script>
@endsection
@section('content')
<div style="min-height: 500px; padding-bottom: 80px;">
	<div class="page_title clearfix">
    <span>我的评论</span>
</div>
    <ul class="address_list">
        @foreach($member_comments as $member_comment)
        <li style="border-bottom: 1px dashed; padding-bottom: 10px;">
            <p>评分：<span class="star" style="width: 200px;" data-score="{{$member_comment->score}}"></span><span>{{$member_comment->created_at}}</span></p>
            <p>评价内容：{{$member_comment->content}}</p>
            <div style=" overflow: hidden;">
            <a href="/m/product/info?id={{$member_comment->book->id}}">
                <i class="pic"><img src="{{makeImgUrl($member_comment->book->main_img)}}" style="float: left; height: 100px;width: 100px; padding-top:10px;"></i>
                <div style="float: left; margin-left: 20px;">
                    <h3 style="margin-top: 10px; margin-bottom: 30px;">{{$member_comment->book->name}}</h3>
                    <b>¥ {{$member_comment->book->price}}</b>
                </div>
            </a>
            </div>
        </li>
            @endforeach
    </ul>
</div>
@endsection
