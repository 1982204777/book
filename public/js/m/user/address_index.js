;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var user_address_index_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.addr_op .del').click(function () {
            $(this).parent().parent().remove();
            $.ajax({
                url:common_ops.buildMUrl("/user/address/ops"),
                type:'POST',
                data:{
                    id:$(this).attr("data"),
                    act:'del'
                },
                dataType:'json',
                success:function( res ){
                }
            });
        });
        $('.addr_op .check_icon').click(function () {
            var id = $(this).attr('data');
            var is_default = $(this).attr('data-default');
            if (is_default === 1) {
                return false;
            }
            $.ajax({
                url:common_ops.buildMUrl('/user/address/ops'),
                type:'post',
                data:{
                    id:id,
                    act:'set_default'
                },
                dataType:'json',
                success:function (res) {
                    if (res.code === 0) {
                        window.location.href = window.location.href;
                    }
                    if (res.code === 2) {
                        return;
                    }
                    // common_ops.alert(res.msg, callback);
                },
                error:function() {
                    if (typeof res === 'object' && res.status !== 500) {
                        common_ops.alert(res.responseJSON.message);
                    } else {
                        common_ops.alert('服务器错误~~~');
                    }
                }
            });
        });
    }
};

$(document).ready(function () {
    user_address_index_ops.init();
});