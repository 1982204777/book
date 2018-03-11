;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var product_info_ops = {
    init:function () {
        this.eventBind();
        this.updateViewCount();
    },
    eventBind:function () {
        $('.fav').click(function () {
            if ($(this).hasClass('has_faved')) {
                return false;
            }
            $.ajax({
                url:common_ops.buildMUrl("/product/fav"),
                type:'POST',
                data:{
                    book_id:$(this).attr("data"),
                    act:'set'
                },
                dataType:'json',
                success:function( res ){
                    common_ops.alert( res.msg );
                },
                error:function (res) {
                    if( res.responseJSON.code === 400 ){
                        common_ops.notlogin();
                        return;
                    }
                }
            });
        });

        $(".add_cart_btn").click( function() {
            $.ajax({
                url:common_ops.buildMUrl("/product/cart"),
                type:'POST',
                data:{
                    act:'set',
                    book_id:$(this).attr("data"),
                    quantity:$(".quantity-form input[name=quantity]").val()
                },
                dataType:'json',
                success:function( res ){
                    common_ops.alert( res.msg );
                },
                error:function (res) {
                    if( res.responseJSON.code === 400 ){
                        common_ops.notlogin();
                        return;
                    }
                }
            });
        });

        $(".order_now_btn").click( function(){
            var book_id = $(this).attr("data");
            var quantity = $(".quantity-form input[name=quantity]").val();
            $.ajax({
                url:common_ops.buildMUrl("/product/order"),
                type:'POST',
                data:{
                    book_id:book_id,
                    quantity:quantity
                },
                dataType:'json',
                success:function( res ){
                    if (res.code === 0) {
                        window.location.href = common_ops.buildMUrl('/product/order?book_id=' + book_id + '&quantity=' + quantity);
                    } else {
                        common_ops.alert(res.msg)
                    }
                },
                error:function (res) {
                    if( res.responseJSON.code === 400 ){
                        common_ops.notlogin();
                        return;
                    }
                }
            });
        });
        //加减效果 start
        $(".quantity-form .icon_lower").click(function () {
            var num = parseInt($(this).next(".input_quantity").val());
            if (num > 1) {
                $(this).next(".input_quantity").val(num - 1);
            }
        });
        $(".quantity-form .icon_plus").click(function () {
            var num = parseInt($(this).prev(".input_quantity").val());
            var max = parseInt($(this).prev(".input_quantity").attr("max"));
            if (num < max) {
                $(this).prev(".input_quantity").val(num + 1);
            }
        });
        //加减效果 end
    },
    updateViewCount:function(){
        $.ajax({
            url:common_ops.buildMUrl("/product/ops"),
            type:'POST',
            data:{
                act:'view_count',
                book_id:$(".pro_fixed input[name=id]").val()
            },
            dataType:'json',
            success:function( res ){
            }
        });
    }
};

$(document).ready(function () {
    product_info_ops.init();
});