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
        $('#brand_image_wrap .pic-each .image_key').html(html);
    }
};
var brand_image_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function() {
        $('.set_pic').click(function() {
            $('#brand_image_wrap').modal('show');
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
            $('#brand_image_wrap .upload_pic_wrap').submit();
        });
        $('#brand_image_wrap .save').click(function() {
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复提交~~~');
                return false;
            }

            var image_key_target = $('#brand_image_wrap .pic-each .image_key span');
            var image_key = image_key_target.attr('data');
            if (image_key.length < 1) {
                common_ops.alert('请选择需要上传的图片~~~')
                return false;
            }
            btn_target.addClass('disabled');
            $.ajax({
                url:common_ops.buildWebUrl('/brand/image'),
                type:'POST',
                data:{
                    image_key:image_key
                },
                dataType:'json',
                success:function(res) {
                    btn_target.removeClass('disabled');
                    var callback = null;
                    if (res.code === 0) {
                        callback = function() {
                            window.location.href = common_ops.buildWebUrl('/brand/images');
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
        $('.remove').click(function() {
            var id = $(this).attr('data');
            var callback = {
              'ok':function() {
                  var btn_target = $(this);
                  if (btn_target.hasClass('disabled')) {
                      common_ops.alert('正在处理，请不要重复提交~~~');
                      return false;
                  }

                  if (id.length < 1) {
                      common_ops.alert('请选择要删除的图片~~~');
                      return false;
                  }
                  btn_target.addClass('disabled');
                  $.ajax({
                      url:common_ops.buildWebUrl('/brand/image-ops'),
                      type:'POST',
                      data:{
                          id:id
                      },
                      dataType:'json',
                      success:function(res) {
                          btn_target.removeClass('disabled');
                          var callback = null;
                          if (res.code === 0) {
                              callback = function() {
                                  window.location.href = window.location.href;
                              };
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
              }
            };
            common_ops.confirm('确定删除吗？', callback)

        });
    }
};

$(document).ready(function() {
    brand_image_ops.init();
});