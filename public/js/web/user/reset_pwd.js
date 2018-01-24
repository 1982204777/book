;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var user_reset_pwd_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function() {
        $('#save').click(function() {
            var btn_reset_pwd_target = $(this);

            if (btn_reset_pwd_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var old_password = $('#old_password').val();
            var new_password = $('#new_password').val();
            if (old_password.length < 1) {
                common_ops.tip('请输入原密码~~~', $('#old_password'));
                return false;
            }
            if (new_password.length < 6) {
                common_ops.tip('请输入至少六位的新密码~~~', $('#new_password'));
                return false;
            }
            if (old_password === new_password) {
                common_ops.alert('重新输入一个吧，原密码与新密码不能相同~~~');
                return false;
            }
            btn_reset_pwd_target.addClass('disabled');
            $.ajax({
                url:'/admin/user/reset-password',
                type:'POST',
                data:{
                    old_password:old_password,
                    new_password:new_password
                },
                dataType:'json',
                success:function(res)
                {
                    btn_reset_pwd_target.removeClass('disabled');
                    callback = null;
                    if (res.code === 0) {
                        callback = function() {
                            window.location.href = window.location.href;
                        };
                    }
                    common_ops.alert(res.msg, callback);
                },
                error:function(res)
                {
                    if (typeof res === 'object' && res.status !== 500) {
                        common_ops.alert(res.responseJSON.message);
                        return false;
                    } else {
                        common_ops.alert('服务器错误~~~');
                        return false;
                    }
                }
            });
        });
    }
};

$(document).ready(function() {
   user_reset_pwd_ops.init();
});