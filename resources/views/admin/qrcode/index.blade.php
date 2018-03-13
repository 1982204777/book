@extends('admin/layout/main')
@section('js')
    <script type="text/javascript" src="/js/web/qrcode/index.js"></script>
@endsection
@section('content')
<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
								<li  class="current"  >
					<a href="/admin/qrcode">渠道二维码</a>
				</li>
							</ul>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="keywords" placeholder="请输入关键字" class="form-control" value="{{request('keywords')}}">
                        <span class="input-group-btn">
                        <button type="button" class="btn  btn-primary search">
                            <i class="fa fa-search"></i>搜索
                        </button>
                    </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/admin/qrcode/create">
                        <i class="fa fa-plus"></i>二维码
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>渠道名称</th>
                <th>二维码</th>
                <th>扫码总数</th>
                <th>注册总数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($qrcode_list as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>
                    <img style="width: 100px;height: 100px;" src="{{'/images/qrcodes/qrcode' . $item['id'] . '.png'}}"/>
                </td>
                <td>{{$item['total_scan_count']}}</td>
                <td>{{$item['total_reg_count']}}</td>
                <td>
                    <a class="m-l" href="qrcode/{{$item['id']}}/edit">
                        <i class="fa fa-edit fa-lg"></i>
                    </a>
                    <a class="m-l remove" href="javascript:void(0);" data="{{$item['id']}}">
                        <i class="fa fa-trash fa-lg"></i>
                    </a>
                </td>
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
                            <li><a href="/admin/qrcode?p={{$p}}">{{$p}}</a></li>
                        @endif
                    @endfor
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection