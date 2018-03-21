@extends('admin/layout/main')
@section('js')
    <script type="text/javascript" src="/plugins/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="/js/web/home/index.js"></script>
    <script type="text/javascript" src="/js/web/chart.js"></script>
@endsection
@section('content')
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">日统计</span>
                            <h5>营收概况（元）</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$data['finance']['today']}}</h1>
                            <small>近30日：{{$data['finance']['month']}}</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">日统计</span>
                            <h5>订单</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$data['order']['today']}}</h1>
                            <small>近30日：{{$data['order']['month']}}</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">日统计</span>
                            <h5>会员</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$data['member']['total']}}</h1>
                            <small>今日新增：{{$data['member']['today']}}</small>
                            <small>近30日新增：{{$data['member']['month']}}</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">日统计</span>
                            <h5>分享</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$data['shared']['today']}}</h1>
                            <small>近30日：{{$data['shared']['month']}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" id="member_order" style="height: 400px;border: 1px solid #e6e6e6;padding-top: 20px;">

                </div>
                <div class="col-lg-12" id="finance" style="height: 400px;border: 1px solid #e6e6e6;padding-top: 20px;">

                </div>
            </div>
        </div>
@endsection