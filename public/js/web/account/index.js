;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var account_index_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function() {
        var that = this;
        $('.search').click(function() {
           $('.wrap_search').submit();
        });

        $('.remove').click(function() {
            that.ops('remove', $(this).attr('data'));
        });
        $('.recover').click(function() {
            that.ops('recover', $(this).attr('data'));
        });
    },
    ops:function(act, uid) {
        callback = {
            "ok":function() {
                $.ajax({
                    url:common_ops.buildWebUrl('/account/ops'),
                    type:'POST',
                    data:{
                        act:act,
                        uid:uid
                    },
                    dataType:'json',
                    success:function(res)
                    {
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
                        } else {
                            common_ops.alert('服务器错误~~~');
                        }
                    }
                });
            },
            "cancel":function() {

            }
        };
        common_ops.confirm((act === 'remove') ? '确定删除吗？' : '确定恢复吗？', callback)

    }
};

$(document).ready(function() {
   account_index_ops.init();
});