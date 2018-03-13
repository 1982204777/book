;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var qrcode_set_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.save').click(function () {
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return ;
            }
            var name_target = $('.wrap_qrcode_set input[name=name]');
            var name = name_target.val();
            if (name.length < 1) {
                common_ops.tip('请输入渠道名称~~~', name_target);
                return ;
            }
            btn_target.addClass('disabled');
            var act = btn_target.attr('data');
            var url = '';
            var data = {name:name};
            if (act === 'add') {
                url = common_ops.buildWebUrl('/qrcode');
            } else {
                url = common_ops.buildWebUrl('/qrcode/' + act);
                data._method = 'PUT';
            }
            $.ajax({
                url:url,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res) {
                    btn_target.removeClass('disabled');
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
        });
    }
};

$(document).ready(function () {
    qrcode_set_ops.init();
});