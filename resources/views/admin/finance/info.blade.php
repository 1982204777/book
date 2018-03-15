@extends('admin.layout.main')
@section('js')
	<script type="text/javascript" src="/js/web/finance/index.js"></script>
@endsection
@section('content')
		<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
				<li  class="current"  >
					<a href="/admin/finance">订单列表</a>
				</li>
				<li>
					<a href="/admin/finance/account">财务流水</a>
				</li>
			</ul>
		</div>
	</div>
</div><div class="row m-t wrap_info">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="m-b-md">
					<h2>订单信息</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">订单编号：{{$pay_order['order_sn']}}</p>
				<p>会员姓名：{{$pay_order['member']['nickname']}}</p>
				<p>会员手机：{{$pay_order['member']['mobile']}}</p>
				<p>订单总价：{{$pay_order['pay_price']}}</p>
				<p>订单状态：{{$pay_status_mapping[$pay_order['status']]}}</p>
								<p>创建时间：{{$pay_order['created_at']}}</p>
                <p>收货地址：{{$city_info['province'] . $city_info['city'] . $city_info['area'] . '（' . $pay_order['member']['address']['nickname'] . '）' . $pay_order['member']['address']['mobile']}}
				</p>
			</div>
		</div>
		<div class="row m-t">
			<div class="col-lg-12">
				<div class="panel blank-panel">
					<div class="panel-heading">
						<div class="panel-options">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab-1" data-toggle="tab" aria-expanded="false">订单商品</a>
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
										<th>商品</th>
										<th>数量</th>
										<th>金额</th>
									</tr>
									</thead>
									<tbody>
									@foreach($pay_order['items'] as $item)
									<tr>
											<td>{{$item['book']['name']}}</td>
											<td>{{$item['quantity']}}</td>
											<td>{{sprintf('%.2f', $item['price'] - $item['discount'])}}</td>
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

<div class="modal fade" id="express_wrap" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">确认发货</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-horizontal m-t m-b">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">发货信息:</label>
                                <div class="col-lg-10">
                                    <label class="control-label">浙江省宁波市330203太阳出来了爬山平（郭威）13774355081</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">快递信息:</label>
                                <div class="col-lg-10">
                                    <input type="text" name="express_info" class="form-control" placeholder="请输入快递信息，例如圆通快递 VIP123123~~" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <input type="hidden" name="pay_order_id" value="32">
                <button type="button" class="btn btn-primary save">保存</button>
            </div>
        </div>
    </div>
</div>
@endsection