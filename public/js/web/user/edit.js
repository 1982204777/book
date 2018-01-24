;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var user_edit_ops = {
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
           var nickname = $('.user_edit_wrap input[name=nickname]').val();
           var email = $('.user_edit_wrap input[name=email]').val();
           if (nickname.length < 1) {
               common_ops.tip('请输入合法的姓名~~~', $('.user_edit_wrap input[name=nickname]'));
               return false;
           }
           if (email.length < 1) {
               common_ops.tip('请输入合法的邮箱地址~~~', $('.user_edit_wrap input[name=email]'))
               return false;
           }
           btn_target.addClass('disabled');

           $.ajax({
               url:'/admin/user/update',
               type:'POST',
               data:{
                   nickname:nickname,
                   email:email
               },
               dataType:'json',
               success:function(res) {
                   if (res.code == 0) {
                       btn_target.removeClass('disabled');
                       callback = null;
                       if (res.code === 0) {
                           callback = function() {
                               window.location.href = window.location.href;
                           }
                       }
                       common_ops.alert(res.msg, callback);
                   }
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

    },
}

$(document).ready(function() {
    user_edit_ops.init();
})