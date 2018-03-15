;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var product_pay_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.op_box .do_pay').click(function () {
            var pay_order_id = $(this).attr('data');
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert( "正在提交，请不要重复提交~~" );
                return ;
            }
            btn_target.addClass("disabled");
            $.ajax({
                url:common_ops.buildMUrl("/product/order/pay"),
                type:'POST',
                data:{
                    pay_order_id:pay_order_id
                },
                dataType:'json',
                success:function( res ){
                    if (res.code === 0) {
                        var pay_target = $('.pay');
                        pay_target.html(res.msg);
                        return ;
                    }
                    common_ops.alert(res.msg());
                }
            });
        });
    }
};

$(document).ready(function () {
    product_pay_ops.init();
});