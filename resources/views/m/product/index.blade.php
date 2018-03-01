@extends('m/layout.main')
@section('js')
    <script type="text/javascript" src="/js/m/product/index.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="search_header">
    <a href="javascript:void(0);" class="category_icon"></a>
    <input name="kw" type="text" class="search_input" placeholder="请输入您搜索的关键词" value="{{$search_conditions['kw']}}" />
    <i class="search_icon"></i>
</div>
<div class="sort_box">
    <ul class="sort_list clearfix">
        <li>
            <a href="javascript:void(0);"  class="{{$search_conditions['sort_field'] == 'default' ? 'aon' : ''}}"  data="default">
                <span>默认</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="{{$search_conditions['sort_field'] == 'month_count' ? 'aon' : ''}}"  data="month_count">
                <span>月销量
                    @if($search_conditions['sort_field'] == 'month_count')
                        @if($search_conditions['sort'] == 'asc')
                            <i class="high_icon"></i>
                        @else
                            <i class="lowly_icon"></i>
                        @endif
                    @else
                        <i></i>
                    @endif
                </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="{{$search_conditions['sort_field'] == 'view_count' ? 'aon' : ''}}"  data="view_count">
                <span>人气
                    @if($search_conditions['sort_field'] == 'view_count')
                        @if($search_conditions['sort'] == 'asc')
                            <i class="high_icon"></i>
                        @else
                            <i class="lowly_icon"></i>
                        @endif
                    @else
                        <i></i>
                    @endif
                </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="{{$search_conditions['sort_field'] == 'price' ? 'aon' : ''}}"  data="price">
                <span>价格
                    @if($search_conditions['sort_field'] == 'price')
                        @if($search_conditions['sort'] == 'asc')
                            <i class="high_icon"></i>
                        @else
                            <i class="lowly_icon"></i>
                        @endif
                    @else
                        <i></i>
                    @endif
                </span>
            </a>
        </li>
    </ul>
</div>
<div class="probox">
            <ul class="prolist">
                @foreach($list as $book)
                <li>
                <a href="/m/product/info?id={{$book->id}}">
                    <i><img src="{{'/storage/' . $book->main_img}}"  style="width: 100%;height: 200px;"/></i>
                    <span>{{$book->name}}</span>
                    <b><label>月销量 {{$book->month_count}}</label>¥{{$book->price}}</b>
                </a>
                </li>
                    @endforeach
            </ul>
    </div>
</div>
@endsection
