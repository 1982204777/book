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
        $('.login_form_wrap .get_captcha').click(function() {
            var mobile_target = $('.login_form_wrap input[name=mobile]');
            var mobile = mobile_target.val();
            if (mobile.length < 1) {
                common_ops.alert('请输入手机号~~~');
                return false;
            }
            if (!that.isPhoneAvailable(mobile_target)) {
                common_ops.alert('请输入符合规范的手机号~~~');
                return false;
            }
            var captcha_target = $('.login_form_wrap input[name=captcha_code]');
            var captcha = captcha_target.val();
            if (captcha.length < 1) {
                common_ops.alert('请输入验证码~~~');
                return false;
            }
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