@extends('admin.layout.main')
@section('js')
@endsection
@section('content')
<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
								<li  >
					<a href="/admin/member">会员列表</a>
				</li>
								<li  class="current"  >
					<a href="/admin/comment">会员评论</a>
				</li>
							</ul>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>头像</th>
                <th>姓名</th>
                <th>手机</th>
                <th>书籍名称</th>
                <th>评论内容</th>
                <th>打分</th>
                <th>评论时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($member_comments as $comment)
            <tr>
                <td>
                    <img alt="image" class="img-circle" src="{{$comment->member->avatar}}" style="width: 40px;height: 40px;">
                </td>
                <td>{{$comment->member->nickname}}</td>
                <td>
                    {{$comment->member->mobile}}
                </td>
                <td>{{$comment->book->name}}</td>
                <td>{{$comment->content}}</td>
                <td>{{$comment->score}}</td>
                <td>{{$comment->created_at}}</td>
            </tr>
                @endforeach
            </tbody>
        </table>
		<div class="row">
            <div class="col-lg-12">
                <span class="pagination_count" style="line-height: 40px;">共{{$page['total_count']}}条记录 | 每页{{$page['page_size']}}条</span>
                <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                    @for($p = 1;$p <= $page['page_count']; $p++)
                        @if($p == $page['current_page'])
                            <li class="active"><span>{{$p}}</span></li>
                        @else
                            <li><a href="/admin/member/comment?p={{$p}}">{{$p}}</a></li>
                        @endif
                    @endfor
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection