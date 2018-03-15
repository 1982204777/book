;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var user_cart_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        var that = this;
        //加减效果 start
        $(".quantity-form .icon_lower").click(function () {
            var num = parseInt($(this).next(".input_quantity").val());
            if (num > 1) {
                $(this).next(".input_quantity").val(num - 1);
                that.setItem( $(this).attr("data-book_id"), $(this).next(".input_quantity").val() )
            }
            that.cal_price();
        });
        $(".quantity-form .icon_plus").click(function () {
            var num = parseInt($(this).prev(".input_quantity").val());
            var max = parseInt($(this).prev(".input_quantity").attr("max"));
            if (num < max) {
                $(this).prev(".input_quantity").val(num + 1);
                that.setItem( $(this).attr("data-book_id"), $(this).prev(".input_quantity").val() )
            }
            that.cal_price();
        });
        //加减效果 end

        //删除
        $(".delC_icon").click(function () {
            $.ajax({
                url:common_ops.buildMUrl("/product/cart"),
                type:'POST',
                data:{
                    id:$(this).attr("data"),
                    act:'del'
                },
                dataType:'json',
                success:function( res ){
                    if( res.code !== 0){
                        if (res.code === 2) {
                            window.location.href = window.location.href;
                        } else {
                            alert( res.msg );
                        }
                    }
                }
            });
            $(this).parent().parent().remove();
            that.cal_price();
        });

        //    结算
        $('.cart_fixed .billing_btn').click(function () {
            var data = [];
            $(".order_pro_list li").each( function(){
                var cart_id = $(this).attr("data");
                data.push( cart_id);
            });

            if (data.length < 1) {
                return ;
            }

            $.ajax({
                url:common_ops.buildMUrl('/product/cartOrder'),
                type:'POST',
                data:{
                    cart_ids:data,
                },
                dataType:'json',
                success:function (res) {
                    if (res.code === 0) {
                        window.location.href = common_ops.buildMUrl('/product/cartOrder?cart_ids=' + data);
                        return ;
                    }
                    common_ops.alert(res.msg);
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
    },
    setItem:function( book_id,quantity ){
        $.ajax({
            url:common_ops.buildMUrl("/product/cart"),
            type:'POST',
            data:{
                book_id:book_id,
                quantity:quantity,
                act:'set',
                update:true
            },
            dataType:'json',
            success:function( res ){
                if( res.code !== 0 ){
                    alert( res.msg );
                }
            }
        });
    },
    cal_price:function(){
        var pay_price = 0;
        $(".order_pro_list li").each( function(){
            var tmp_price = parseFloat( $(this).attr("data-price") );
            var tmp_quantity = $(this).find(".input_quantity").val();
            pay_price += tmp_price * parseInt( tmp_quantity );
        });
        $(".cart_fixed #price").html( pay_price.toFixed(2) );
    }
};

$(document).ready(function () {
   user_cart_ops.init();
});