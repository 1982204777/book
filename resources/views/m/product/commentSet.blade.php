@extends('m.layout.main')
@section('js')
    <script src="/plugins/raty/jquery.raty.min.js"></script>
    <script src="/js/m/product/comment.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="page_title clearfix">
    <span>我要评论</span>
</div>
<div class="addr_form_box">
    <div class="addr_input_box">
        <span>服务打分</span>
        <div id="star" style="width: 100%;padding:1.3rem 0"></div>
    </div>
    <div class="addr_input_box">
        <span>评价内容</span>
        <textarea name="content" rows="2" cols="20" placeholder="请填写本次购买的评价~~" class="addr_textarea"></textarea>
    </div>
</div>
<div class="op_box">
    <input type="hidden" name="pay_order_id" value="{{$pay_order->id}}">
    <input type="hidden" name="book_id" value="{{$book->id}}">
    <input  type="button" value="确定" class="red_btn save" style="width: 100%;" />
</div>
</div>
@endsection
