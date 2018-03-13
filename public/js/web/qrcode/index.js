;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var qrcode_index_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function() {
        $('.search').click(function() {
            $('.wrap_search').submit();
        });

        $('.remove').click(function() {
            var id = $(this).attr('data');
            if (!id || id.length < 1) {
                common_ops.alert('渠道不存在~~~');
                return ;
            }

            callback = {
                "ok":function() {
                    $.ajax({
                        url:common_ops.buildWebUrl('/qrcode/' + id + '/delete'),
                        type:'post',
                        dataType:'json',
                        success:function(res) {
                            var callback = null;
                            if (res.code === 0) {
                                callback = function () {
                                    window.location.href = common_ops.buildWebUrl('/qrcode');
                                }
                            }
                            common_ops.alert(res.msg, callback);
                        },
                        error:function(res) {
                            if (typeof res === 'object' && res.status !== 500) {
                                common_ops.alert(res.responseJSON.message);
                            } else {
                                common_ops.alert('服务器错误~~~');
                            }
                        }
                    });
                },
                "cancel":function() {

                }
            };


            common_ops.confirm('确定删除吗？', callback);
        });

    },
};

$(document).ready(function() {
    qrcode_index_ops.init();
});