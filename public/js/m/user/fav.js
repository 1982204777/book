;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var user_fav_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        //删除
        $(".del_fav").click(function () {
            $.ajax({
                url:common_ops.buildMUrl("/product/fav"),
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
            $(this).parent().remove();
        });
    }
};

$(document).ready(function () {
   user_fav_ops.init();
});