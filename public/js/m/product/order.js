;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var product_order_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.do_order').click(function () {
            var address_id = $('.order_box input[name=address_id]').val();
            if (!address_id) {
                common_ops.alert('请选择收货地址~~~');
            }
            var data = [];
            $(".order_list li").each( function(){
                var tmp_book_id = $(this).attr("data");
                var tmp_quantity = $(this).attr("data-quantity");
                data.push( tmp_book_id + "#" + tmp_quantity );
            });

            if( data.length < 1 ){
                common_ops.alert("请选择了商品在提交~~~");
                return;
            }
            $.ajax({
                url:common_ops.buildMUrl('/product/placeOrder'),
                type:'POST',
                data:{
                    product_items:data,
                    address_id:address_id
                },
                dataType:'json',
                success:function (res) {
                    var callback = '';
                    if (res.code === 0) {
                        var url = res.msg.url;
                        callback = function () {
                            window.location.href = url;
                        }
                        console.log(res.msg.msg);
                        console.log(url);
                        console.log(callback);
                        common_ops.alert(res.msg.msg, callback);
                        return;
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
    }
};

$(document).ready(function () {
    product_order_ops.init();
});