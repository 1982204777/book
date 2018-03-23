;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var wechat_bind_ops = {
    init:function()
    {
        this.eventBind();
    },
    eventBind:function()
    {
        var that = this;
        var mobile_target = $('.login_form_wrap input[name=mobile]');
        var img_captcha_target = $('.login_form_wrap input[name=img_captcha]');
        var mobile_captcha_target = $('.login_form_wrap input[name=captcha_code]');
        $('.login_form_wrap .get_captcha').click(function(){
            var btn_target = $(this);
            var mobile = mobile_target.val();
            var img_captcha = img_captcha_target.val();
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            if (mobile.length < 1) {
                common_ops.alert('请输入手机号~~~');
                return false;
            }
            if (!that.isPhoneAvailable(mobile_target)) {
                common_ops.alert('请输入符合规范的手机号~~~');
                return false;
            }

            if (img_captcha.length < 1) {
                common_ops.alert('请输入验证码~~~');
                return false;
            }
            btn_target.addClass('disabled');
            $.ajax({
                url:'bind/img-captcha',
                type:'GET',
                data:{
                    mobile:mobile,
                    img_captcha:img_captcha
                },
                dataType:'json',
                success:function(res)
                {
                    btn_target.removeClass('disabled');
                    common_ops.alert(res.msg)
                },
                error:function()
                {

                }
            });
        });
        $('.login_form_wrap .dologin').click(function() {
            var btn_target = $(this);
            var mobile = mobile_target.val();
            var img_captcha = img_captcha_target.val();
            var mobile_captcha = mobile_captcha_target.val();
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            if (mobile.length < 1) {
                common_ops.alert('请输入手机号~~~');
                return false;
            }
            if (!that.isPhoneAvailable(mobile_target)) {
                common_ops.alert('请输入符合规范的手机号~~~');
                return false;
            }
            if (img_captcha.length < 1) {
                common_ops.alert('请输入验证码~~~');
                return false;
            }
            if (mobile_captcha.length < 1) {
                common_ops.alert('请输入手机验证码~~~');
                return false;
            }
            btn_target.addClass('disabled');

            $.ajax({
                url:'bind',
                type:'POST',
                data:{
                    mobile:mobile,
                    img_captcha:img_captcha,
                    mobile_captcha:mobile_captcha
                },
                dataType:'json',
                success:function(res) {
                    btn_target.removeClass('disabled');
                    var callback = null;
                    if (res.code === 2) {
                        callback = function () {
                            window.location.href = '/m/oauth/login?scope=snsapi_userinfo';
                        }
                    }
                    if (res.code === 1) {
                        callback = function () {
                            window.location.href = '/m/home';
                        }
                    }

                    common_ops.alert(res.msg, callback);
                },
                error:function() {
                    if (typeof res === 'object' && res.status !== 500) {
                        common_ops.alert(res.responseJSON.message);
                    } else {
                        common_ops.alert('服务器错误~~~');
                    }
                }
            });
        });
    },
    isPhoneAvailable:function(mobile_target) {
        var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
        if (!myreg.test(mobile_target.val())) {
            return false;
        } else {
            return true;
        }
    }
};

$(document).ready(function() {
    wechat_bind_ops.init();
});
