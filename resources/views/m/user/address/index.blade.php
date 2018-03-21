@extends('m.layout.main')
@section('js')
	<script src="/js/m/user/address_index.js"></script>
@endsection
@section('content')
<div style="min-height: 500px;">
	<div class="page_title clearfix">
    <span>常用收货地址</span>
</div>
	<ul class="address_list">
		@if($member_addresses->isNotEmpty())
		@foreach($member_addresses as $address)
    	<li>
		<p><span>{{$address->nickname}}</span>{{$address->mobile}}</p>
		<p>{{$address->address}}</p>
		<div class="addr_op">
			<em class="del" data="{{$address->id}}" style="z-index: 9999;"><i class="del_icon"></i>删除</em>
			<a href="/m/user/address/{{$address->id}}/edit" class="address_edit" style="z-index: 9999;"><i class="edit_icon" ></i>编辑</a>
			@if($address->is_default == 1)
			<div class="default_set"><i class="check_icon" id="set_default" data="{{$address->id}}" data-default="{{$address->is_default}}"></i><span class="set_default_text">默认地址</span></div>
			@else
			<div class="default_set"><i class="check_icon" data="{{$address->id}}" data-default="{{$address->is_default}}"></i><span>设为默认</span></div>
				@endif
		</div>
		</li>
			@endforeach
			@else
			<h4 style="text-align: center;padding-top: 1rem;">连个收货地址都没有，还搞啥互联网哇~~~</h4>
		@endif
    </ul>


<div class="op_box" style="padding-bottom: 80px">
    <a href="/m/user/address/create" class="red_btn" style="color: #ffffff;">添加新地址</a>
</div>
</div>
@endsection
