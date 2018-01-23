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
                alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var old_password = $('#old_password').val();
            var new_password = $('#new_password').val();
            if (old_password.length < 1) {
                alert('请输入原密码~~~');
                return false;
            }
            if (new_password.length.length < 6) {
                alert('请输入至少六位的新密码~~~');
                return false;
            }
            if (old_password === new_password) {
                alert('重新输入一个吧，原密码与新密码不能相同~~~');
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
                    alert(res.msg);
                    if (res.code === 0) {
                        window.location.href = window.location.href;
                    }
                },
                error:function(res)
                {
                    if (typeof res === 'object' && res.status !== 500) {
                        alert(res.responseJSON.message);
                        return false;
                    } else {
                        alert('服务器错误~~~');
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