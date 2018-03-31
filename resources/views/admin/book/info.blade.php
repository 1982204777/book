@extends('admin.layout.main')
@section('js')
    <script type="text/javascript" src="/js/web/account/index.js"></script>
@endsection
@section('content')
    <div class="row  border-bottom">
        <div class="col-lg-12">
            <div class="tab_title">
                <ul class="nav nav-pills">
                    <li  class="current"  >
                        <a href="/admin/book">图书列表</a>
                    </li>
                    <li  >
                        <a href="/admin/book/category">分类列表</a>
                    </li>
                    <li  >
                        <a href="/admin/book/images">图片资源</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <style type="text/css">
	.wrap_info img{
		width: 70%;
	}
</style>
<div class="row m-t wrap_info">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="m-b-md">
											<a class="btn btn-outline btn-primary pull-right" href="/admin/book/{{$book->id}}/edit">
							<i class="fa fa-pencil"></i>编辑
						</a>
										<h2>图书信息</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">图书名称：{{$book->name}}</p>
				<p>图书售价：{{$book->price}}</p>
				<p>库存总量：{{$book->stock}}</p>
				<p>图书标签：{{$book->tags}}</p>
				<p>封面图：<img src="{{'/storage/' . $book->main_img}}" style="width: 100px;"/> </p>
				<p>图书描述：{!!$book->summary!!}</p>
			</div>
		</div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">销售历史</a>
                                </li>
                                <li>
                                    <a href="#tab-2" data-toggle="tab" aria-expanded="true">库存变更</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>会员名称</th>
                                        <th>购买数量</th>
                                        <th>购买价格</th>
                                        <th>订单状态</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($book->payOrderItems as $item)
                                    <tr>
                                        <td>
                                            {{$item->member->nickname}}
                                        </td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$book->price}}</td>
                                        <td>{{$pay_status_mapping[$item->order->status]}}</td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>变更</th>
                                        <th>剩余库存</th>
                                        <th>备注</th>
                                        <th>时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($book->stock_change_logs as $log)
                                    <tr>
                                        <td>{{$log->unit}}</td>
                                        <td>{{$log->total_stock}}</td>
                                        <td>{{$log->note}}</td>
                                        <td>{{$log->created_at}}</td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
