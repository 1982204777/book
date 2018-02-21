;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
var upload = {
    error:function(msg) {
        common_ops.alert(msg);
    },
    success:function(image_key) {
        var html = '<span data="'+image_key+'"></span>';
        $('.wrap_brand_set .pic-each .image_key').html(html);
    }
};
var brand_set_ops = {
    init:function() {
        this.eventBind();
        // this.delete_image();
    },
    eventBind:function() {
        $('.wrap_brand_set .save').click(function() {
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var name_target = $('.wrap_brand_set input[name=name]');
            var name = name_target.val();

            var image_key_target = $('.wrap_brand_set .pic-each .image_key span');
            if (image_key_target.length === 0) {
                common_ops.alert('请上传品牌logo~~~');
                return false;
            }
            var image_key = image_key_target.attr('data');

            var mobile_target = $('.wrap_brand_set input[name=mobile]');
            var mobile = mobile_target.val();

            var address_target = $('.wrap_brand_set input[name=address]');
            var address = address_target.val();

            var description_target = $('.wrap_brand_set textarea[name=description]');
            var description = description_target.val();

            if (name.length < 1) {
                common_ops.tip('请输入符合规范的品牌名~~~', name_target);
                return ;
            }
            if (image_key.length < 1) {
                common_ops.alert('请上传品牌logo~~~');
                return ;
            }
            if (mobile.length < 1) {
                common_ops.tip('请输入符合规范的联系电话~~~', mobile_target);
                return ;
            }
            if (address.length < 1) {
                common_ops.tip('请输入符合规范的地址~~~', address_target);
                return ;
            }
            if (description.length < 1) {
                common_ops.tip('请输入符合规范的品牌介绍~~~', description_target);
                return ;
            }
            btn_target.addClass('disabled');
            $.ajax({
                url:common_ops.buildWebUrl('/brand/set'),
                type:'POST',
                data:{
                    name:name,
                    image_key:image_key,
                    mobile:mobile,
                    address:address,
                    description:description
                },
                dataType:'json',
                success:function(res) {
                    btn_target.removeClass('disabled');
                    var callback = null;
                    if (res.code === 0) {
                        callback = function() {
                            window.location.href = common_ops.buildWebUrl('/brand/info');
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


        $(".preview_input").change(function(event){
            var file = event.currentTarget.files[0];
            var file_size = file.size / 1024;
            if (file_size > 2048) {
                common_ops.alert('上传的图片过大，请选择不超过2mb的图片~~~');
                return ;
            }
            var url = window.URL.createObjectURL(file);
            $(".preview_img").attr("src",url);
            // $('.wrap_brand_set .pic-each .del_image').removeClass('hidden');
            $('.wrap_brand_set .upload_pic_wrap').submit();
        });
    },
    // delete_image:function() {
    //     $('.wrap_brand_set .del_image').unbind().click(function() {
    //         $(".preview_img").attr("src",'');
    //         $('.image_key span').remove();
    //         $(this).remove();
    //     });
    // }
};

$(document).ready(function() {
    brand_set_ops.init();
});