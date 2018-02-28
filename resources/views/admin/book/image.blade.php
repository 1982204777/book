@extends('admin.layout.main')
@section('js')
	<script type="text/javascript" src="/js/web/book/index.js"></script>
@endsection
@section('content')
	<div class="row  border-bottom">
		<div class="col-lg-12">
			<div class="tab_title">
				<ul class="nav nav-pills">
					<li>
						<a href="/admin/book">图书列表</a>
					</li>
					<li  >
						<a href="/admin/book/category">分类列表</a>
					</li>
					<li class="current">
						<a href="/admin/book/images">图片资源</a>
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
				<th>图片</th>
				<th>图片地址</th>
			</tr>
			</thead>
			<tbody>
            @foreach($images as $image)
            <tr>
                <td>
                    <img src="{{'/storage/' . $image->file_key}}" style="width: 100px;"/>
                </td>
                <td>
                    <a href="{{'http://' . request()->getHost() . '/storage/' . $image->file_key}}" target="_blank">查看大图</a>
                </td>
            </tr>
                @endforeach
            </tbody>
		</table>
		<div class="row">
	<div class="col-lg-12">
        <div class="col-lg-12">
            <span class="pagination_count" style="line-height: 40px;">共{{$page['total_count']}}条记录 | 每页{{$page['page_size']}}条</span>
            <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                @for($p = 1;$p <= $page['page_count']; $p++)
                    @if($p == $page['current_page'])
                        <li class="active"><span>{{$p}}</span></li>
                    @else
                        <li><a href="/admin/book/images?p={{$p}}">{{$p}}</a></li>
                    @endif
                @endfor
            </ul>
        </div>
	</div>
</div>
	</div>
</div>
@endsection
