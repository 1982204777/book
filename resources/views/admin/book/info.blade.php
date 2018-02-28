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
																			                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-03-16 16:24:37</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-03-16 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-03-15 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-03-14 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-03-13 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-03-12 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-03-11 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-03-10 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-03-09 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-03-08 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-03-07 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-03-06 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-03-05 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-03-04 16:24:10</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-03-03 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-03-02 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-03-01 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-02-28 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-27 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-02-26 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-02-25 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-02-24 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-02-23 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-02-22 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-02-21 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-02-20 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-19 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-18 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-02-17 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-16 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-02-15 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-02-14 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-13 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-02-12 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-02-11 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-02-10 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-02-09 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-02-08 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-02-07 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-06 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-02-05 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-02-04 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-02-03 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-02 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-02-01 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-01-31 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-01-30 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-29 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-28 16:24:09</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-01-27 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-01-26 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-01-25 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-24 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-23 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-22 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-01-21 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-01-20 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-01-19 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-01-18 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-01-17 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-01-16 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-01-15 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-01-14 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-13 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-01-12 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-01-11 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-01-10 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-01-09 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-01-08 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-01-07 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-01-06 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-01-05 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-01-04 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-01-03 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-01-02 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-01-01 16:24:08</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-03-16 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-03-15 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-03-14 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-03-13 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-03-12 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-03-11 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-03-10 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-03-09 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-03-08 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-03-07 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-03-06 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-03-05 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-03-04 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-03-03 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-03-02 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-03-01 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-02-28 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-27 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-26 15:56:35</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-02-25 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-24 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-02-23 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-02-22 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-02-21 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-02-20 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-19 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-18 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-02-17 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-16 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-02-15 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-02-14 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-02-13 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-02-12 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-02-11 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-02-10 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-09 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-02-08 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-02-07 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-02-06 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-02-05 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-02-04 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-02-03 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-02-02 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>6</td>
                                                <td>533.28</td>
                                                <td>2017-02-01 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-31 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-30 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-29 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-01-28 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-01-27 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-01-26 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-01-25 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-01-24 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-01-23 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-22 15:56:34</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-01-21 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-01-20 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-01-19 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-01-18 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-01-17 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-01-16 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-15 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>4</td>
                                                <td>355.52</td>
                                                <td>2017-01-14 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-01-13 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-01-12 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-11 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-10 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-09 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>2</td>
                                                <td>177.76</td>
                                                <td>2017-01-08 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>3</td>
                                                <td>266.64</td>
                                                <td>2017-01-07 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>1</td>
                                                <td>88.88</td>
                                                <td>2017-01-06 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>7</td>
                                                <td>622.16</td>
                                                <td>2017-01-05 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>10</td>
                                                <td>888.80</td>
                                                <td>2017-01-04 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>8</td>
                                                <td>711.04</td>
                                                <td>2017-01-03 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>5</td>
                                                <td>444.40</td>
                                                <td>2017-01-02 15:56:33</td>
                                            </tr>
										                                            <tr>
                                                <td>
                                                                                                        郭威                                                                                                    </td>
                                                <td>9</td>
                                                <td>799.92</td>
                                                <td>2017-01-01 15:56:33</td>
                                            </tr>
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
