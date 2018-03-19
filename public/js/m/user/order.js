;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var user_order_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $(".order_header").click(function () {
            $(this).next().toggle();
        });
        $('.op_box .close').click(function () {
            if( !confirm("确认取消订单？") ){
                return;
            }
            var pay_order_id = $(this).attr('data');
            $.ajax({
                url:common_ops.buildMUrl('/user/orderOps'),
                type:'POST',
                data:{
                    pay_order_id:pay_order_id,
                    act:"close"
                },
                dataType:'json',
                success:function (res) {
                    if (res.code === 0) {
                       window.location.href = window.location.href;
                    } else {
                        common_ops.alert(res.msg);
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
    }
};

$(document).ready(function () {
    user_order_ops.init();
});