;
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var book_category_set_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.wrap_cat_set .save').click(function () {
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var name_target = $('.wrap_cat_set input[name=name]');
            var name = name_target.val();
            if (name.length < 1) {
                common_ops.tip('请输入符合规范的分类名称~~~', name_target);
                return false;
            }
            var weight_target = $('.wrap_cat_set input[name=weight]');
            var weight = weight_target.val();
            if (!(/(^[1-9]\d*$)/.test(weight))) {
                common_ops.tip('请输入符合规范的权重~~~', weight_target);
                return false;
            }
            btn_target.addClass('disabled');
            var action = $(this).attr('data');
            var data = null;
            var url = null;
            if (action === 'create') {
                data = {
                    name:name,
                    weight:weight
                };
                url = common_ops.buildWebUrl('/book/category');
            } else {
                data = {
                    _method:"PUT",
                    name:name,
                    weight:weight
                };
                url = common_ops.buildWebUrl('/book/category/' + action);
            }
            $.ajax({
                url:url,
                type:'post',
                data:data,
                dataType:'json',
                success:function(res) {
                    btn_target.removeClass('disabled');
                    var callback = null;
                    if (res.code === 0) {
                        callback = function () {
                            window.location.href = common_ops.buildWebUrl('/book/category');
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
    book_category_set_ops.init();
});