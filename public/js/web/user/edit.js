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
                alert('正在处理，请不要重复点击~~~');
                return false;
            }
           var nickname = $('.user_edit_wrap input[name=nickname]').val();
           var email = $('.user_edit_wrap input[name=email]').val();
           if (nickname.length < 1) {
               alert('请输入合法的姓名~~~');
               return false;
           }
           if (email.length < 1) {
               alert('请输入合法的邮箱地址~~~')
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
                       alert(res.msg);
                       window.location.href = window.location.href;
                   }
               },
               error:function(res) {
                   if (typeof res === 'object' && res.status !== 500) {
                       alert(res.responseJSON.message);
                   } else {
                       alert('服务器错误~~~');
                   }
               }
           });
        });

    },
}

$(document).ready(function() {
    user_edit_ops.init();
})