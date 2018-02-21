;
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var member_set_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.save').click(function(){
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var nickname_target = $('.wrap_member_set input[name=nickname]');
            var nickname = nickname_target.val();
            if (nickname.length < 1) {
                common_ops.alert('请输入符合规范的会员名~~~');
                return false;
            }

            var mobile_target = $('.wrap_member_set input[name=mobile]');
            var mobile = mobile_target.val();
            if (mobile.length < 1) {
                common_ops.alert('请输入符合规范的会员手机号~~~');
                return false;
            }

            btn_target.addClass('disabled');
            var action = $(this).attr('data');
            var data = null;
            var url = null;
            if (action === 'create') {
                data = {
                    nickname:nickname,
                    mobile:mobile
                };
                url = common_ops.buildWebUrl('/member');
            } else {
                data = {
                    _method:"PUT",
                    nickname:nickname,
                    mobile:mobile
                };
                url = common_ops.buildWebUrl('/member/' + action);
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
                            window.location.href = common_ops.buildWebUrl('/member');
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
    member_set_ops.init();
});