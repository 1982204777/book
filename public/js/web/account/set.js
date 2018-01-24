;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var account_add_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function() {
        $('.save').click(function() {
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var nickname_target = $('.wrap_account_set input[name=nickname]');
            var nickname = nickname_target.val();

            var mobile_target = $('.wrap_account_set input[name=mobile]');
            var mobile = mobile_target.val();

            var email_target = $('.wrap_account_set input[name=email]');
            var email = email_target.val();

            var login_name_target = $('.wrap_account_set input[name=login_name]');
            var login_name = login_name_target.val();

            var login_pwd_target = $('.wrap_account_set input[name=login_pwd]');
            var login_pwd = login_pwd_target.val();
            if (nickname.length < 1) {
                common_ops.tip('请输入姓名~~~', nickname_target);
                return;
            }
            if (mobile.length < 1) {
                common_ops.tip('请输入正确的手机号码~~~', mobile_target);
                return;
            }
            if (email.length < 1) {
                common_ops.tip('请输入正确的邮箱~~~', email_target);
                return;
            }
            if (login_name.length < 1) {
                common_ops.tip('请输入用户名~~~', login_name_target);
                return;
            }
            if (login_pwd.length < 1) {
                common_ops.tip('请输入密码~~~', login_pwd_target);
                return;
            }
            btn_target.addClass('disabled');
            var data = $(this).attr('data');
            if (data === 'create') {
                $.ajax({
                    url:common_ops.buildWebUrl('/account'),
                    type:'POST',
                    data:{
                        nickname:nickname,
                        mobile:mobile,
                        email:email,
                        login_name:login_name,
                        login_pwd:login_pwd
                    },
                    dataType:'json',
                    success:function(res) {
                        btn_target.removeClass('disabled');
                        var callback = null;
                        if (res.code === 0) {
                            callback = function() {
                                window.location.href = common_ops.buildWebUrl('/account');
                            };
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
            } else {
                $.ajax({
                    url:'/admin/account/' + data,
                    type: 'POST',
                    data:{
                        _method:"PUT",
                        nickname:nickname,
                        mobile:mobile,
                        email:email,
                        login_name:login_name,
                        login_pwd:login_pwd
                    },
                    dataType:'json',
                    success:function(res) {
                        console.log(res);
                        btn_target.removeClass('disabled');
                        var callback = null;
                        if (res.code === 0) {
                            callback = function() {
                                window.location.href = common_ops.buildWebUrl('/account');
                            };
                        }
                        common_ops.alert(res.msg, callback);
                    },
                    error:function(res) {
                        console.log('err', res);
                        if (typeof res === 'object' && res.status !== 500) {
                            common_ops.alert(res.responseJSON.message);
                        } else {
                            common_ops.alert('服务器错误~~~');
                        }
                    }
                });
            }
        });
    }
};

$(document).ready(function() {
    account_add_ops.init();
});