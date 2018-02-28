;
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var upload = {
    error:function(msg) {
        common_ops.alert(msg);
    },
    success:function(image_key) {
        console.log(image_key);
        var html = '<span data="'+image_key+'"></span>';
        $('.wrap_book_set .pic-each .image_key').html(html);
    }
};

var book_set_ops = {
    init:function () {
        this.ue = null;
        this.eventBind();
        this.initEditor();
    },
    eventBind:function () {
        var that = this;

        $(".wrap_book_set input[name=tags]").tagsInput({
            width:'auto',
            height:40,
            onAddTag:function(tag){
            },
            onRemoveTag:function(tag){
            }
        });

        $(".wrap_book_set select[name=cat_id]").select2({
            language: "zh-CN",
            width:'100%'
        });

        $('.wrap_book_set .save').click(function () {
            var btn_target = $(this);
            if (btn_target.hasClass('disabled')) {
                common_ops.alert('正在处理，请不要重复点击~~~');
                return false;
            }
            var cat_id_target = $(".wrap_book_set select[name=cat_id]");
            var cat_id = cat_id_target.val();

            var name_target = $(".wrap_book_set input[name=name]");
            var name = name_target.val();

            var price_target = $(".wrap_book_set input[name=price]");
            var price = price_target.val();

            var main_img_target = $(".wrap_book_set .pic-each .image_key span");
            var main_img = main_img_target.attr('data');

            var summary_target = $('.wrap_book_set #editor');
            var summary  = $.trim( that.ue.getContent() );

            var stock_target = $(".wrap_book_set input[name=stock]");
            var stock = stock_target.val();

            var tags_target = $(".wrap_book_set input[name=tags]");

            var tags = $.trim( tags_target.val() );

            if( parseInt( cat_id ) < 1 ){
                common_ops.tip( "请选择图书分类~~~" ,cat_id_target );
                return;
            }

            if( name.length < 1 ){
                common_ops.tip( "请输入符合规范的图书名称~~~", name_target);
                return;
            }

            if( parseFloat( price ) <= 0 || isNaN(price) || !price){
                common_ops.tip( "请输入符合规范的图书售卖价格~~~" ,price_target );
                return;
            }

            if( !main_img){
                common_ops.alert( "请上传封面图~~~"  );
                return;
            }

            if( summary.length < 10 ){
                common_ops.tip( "请输入图书描述，并不能少于10个字符~~~" ,summary_target );
                return;
            }

            if( parseInt( stock ) < 1 || isNaN(stock) || !stock){
                common_ops.tip( "请输入符合规范的库存量~~~" ,stock_target );
                return;
            }

            if( tags.length < 1 ){
                common_ops.alert( "请输入图书标签，便于搜索~~~" );
                return;
            }

            btn_target.addClass("disabled");

            var action = $(this).attr('data');
            var url = '';
            var data = {
                cat_id:cat_id,
                name:name,
                price:price,
                main_img:main_img,
                summary:summary,
                stock:stock,
                tags:tags
            };
            if (action === 'create') {
                url = common_ops.buildWebUrl('/book');
            } else {
                url = common_ops.buildWebUrl('/book/' + action)
                data._method = 'PUT';
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
                            window.location.href = common_ops.buildWebUrl('/book');
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
            $('.wrap_book_set .upload_pic_wrap').submit();
        });
    },
    initEditor:function(){
        var that = this;
        that.ue = UE.getEditor('editor',{
            toolbars: [
                [ 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall',  '|','rowspacingtop', 'rowspacingbottom', 'lineheight'],
                [ 'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink'],
                [ 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'horizontal', 'spechars','|','inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols' ]

            ],
            enableAutoSave:true,
            saveInterval:60000,
            elementPathEnabled:false,
            zIndex:4
        });
        that.ue.addListener('beforeInsertImage', function (t,arg){
            console.log( t,arg );
            //alert('这是图片地址：'+arg[0].src);
            // that.ue.execCommand('insertimage', {
            //     src: arg[0].src,
            //     _src: arg[0].src,
            //     width: '250'
            // });
            return false;
        });
    }
};

$(document).ready(function () {
    book_set_ops.init();
});