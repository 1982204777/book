;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var address_set_ops = {
    init:function () {
        this.province_infos = {};
        this.eventBind();
        this.init_select();
    },
    eventBind:function () {
        var that = this;
        $('.op_box .save').click(function () {
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var nickname = $('.addr_form_box input[name=nickname]').val();
            var mobile = $('.addr_form_box input[name=mobile]').val();
            var province_id = $('#province_id').val();
            var city_id = $('#city_id').val();
            var area_id = $('#area_id').val();
            var address = $('.addr_form_box textarea[name=address]').val();
            if (!nickname || nickname.length < 1) {
                common_ops.alert('请输入收货人姓名~~~');
                return false;
            }
            if (!/^[1-9]\d{10}$/.test(mobile)) {
                common_ops.alert('请输入符合规范的收货人联系电话~~~');
                return false;
            }
            if (province_id < 1) {
                common_ops.alert('请选择省份~~~');
                return false;
            }
            if (city_id < 1) {
                common_ops.alert('请选择城市~~~');
                return false;
            }
            if (area_id < 1) {
                common_ops.alert('请选择区~~~');
                return false;
            }
            if (address.length < 3) {
                common_ops.alert('请输入符合规范的地址~~~');
                return false;
            }
            btn_target.addClass('disabled');
            var act = btn_target.attr('data');
            var url = '';
            var data = {
                nickname:nickname,
                mobile:mobile,
                province_id:province_id,
                city_id:city_id,
                area_id:area_id,
                address:address
            };
            if (act == 'add') {
                url = common_ops.buildMUrl('/user/address');
            } else {
                url = common_ops.buildMUrl('/user/address/' + act);
                data._method = 'put';
            }
            $.ajax({
                url:url,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res) {
                    btn_target.removeClass('disabled');
                    var callback = '';
                    if (res.code === 0) {
                        callback = function () {
                            window.location.href = common_ops.buildMUrl('/user/address');
                        }
                    }
                    common_ops.alert(res.msg,callback);
                },
                error:function(res) {
                    if (typeof res === 'object' && res.status !== 500) {
                        common_ops.alert(res.responseJSON.message);
                    } else {
                        common_ops.alert('服务器错误~~~');
                    }
                }
            });
        });
        $('#province_id').change(function () {
            $("#area_id").html("");
            $("#area_id").append("<option value='0'>请选择区</option>");
            var id = $(this).val();
            if (id <= 0) {
                return false;
            }
            $.ajax({
                url:common_ops.buildMUrl('/user/address/getProvinceCityTree'),
                type:'POST',
                data:{
                    province_id:id
                },
                dataType:'json',
                success:function(res) {
                    if (res.code === 0) {
                        that.province_infos[id] = res.msg;
                        that.province_cascade();
                    }
                },
                error:function(res) {
                    if (typeof res === 'object' && res.status !== 500) {
                        common_ops.alert(res.responseJSON.message);
                    } else {
                        common_ops.alert('服务器错误~~~');
                    }
                }
            });
        });

        $('#city_id').change(function () {
            that.city_cascade()
        });
    },
    province_cascade:function(){
        var id = $("#province_id").val();
        var province_info = this.province_infos[id];
        var city_info = province_info.city;
        if(id <= 0){
            return;
        }
        $("#city_id").html("");
        $("#city_id").append("<option value='0'>请选择市</option>");
        for(var idx in city_info){
            if( parseInt($("#city_id_before").val()) == city_info[idx]['id']){
                $("#city_id").append("<option value='"+city_info[idx]['id']+"' selected='select'>"+city_info[idx]['name']+"</option>");
                continue;
            }
            $("#city_id").append("<option value='"+city_info[idx]['id']+"'>"+city_info[idx]['name']+"</option>");
        }
        this.city_cascade();
    },
    city_cascade:function(){
        var id = $("#province_id").val();
        var province_info = this.province_infos[id];
        var city_id =$("#city_id").val();
        var district_info = province_info.district[city_id];
        if(id<=0 || city_id<=0){
            return;
        }
        $("#area_id").html("");
        $("#area_id").append("<option value='0'>请选择区</option>");
        for(var idx in district_info){
            if( parseInt( $("#area_id_before").val() ) == district_info[idx]['id'] ){
                $("#area_id").append("<option value='"+district_info[idx]['id']+"' selected='select'>"+district_info[idx]['name']+"</option>");
                continue;
            }

            $("#area_id").append("<option value='"+district_info[idx]['id']+"'>"+district_info[idx]['name']+"</option>");
        }
    },
    init_select:function () {
        if ($('#province_id').val() > 0) {
            $('#province_id').change();
        }
        if ($('#city_id').val() > 0) {
            $('#province_id').change();
        }
    },
};

$(document).ready(function () {
    address_set_ops.init();
});