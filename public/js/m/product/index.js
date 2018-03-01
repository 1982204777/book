;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var product_index_ops = {
    init:function () {
        this.p = 1;
        this.sort_field = "default";
        this.sort = "";
        this.$_GET = (function(){
            var url = window.document.location.href.toString();
            var u = url.split("?");
            if(typeof(u[1]) == "string"){
                u = u[1].split("&");
                var get = {};
                for(var i in u){
                    var j = u[i].split("=");
                    get[j[0]] = j[1];
                }
                return get;
            } else {
                return {};
            }
        })();
        this.eventBind();
    },
    eventBind:function () {
        var that = this;
        $('.search_header .search_icon').click(function () {
            that.search(true);
        });

        $('.sort_box .sort_list li a').click(function () {
            that.sort_field = $(this).attr("data");
            if( $(this).find("i").hasClass("lowly_icon")  ){
                that.sort = "asc"
            } else {
                that.sort = "desc"
            }
            that.search();
        });

        var process = true;
        $( window ).scroll( function() {
            if( ( ( $(window).height() + $(window).scrollTop() ) > $(document).height() - 20 ) && process ){
                process = false;
                that.p += 1;
                var sort_field = that.$_GET['sort_field'];
                var sort = that.$_GET['sort'];
                this.sort_field = sort_field;
                this.sort = sort;
                var data = {
                    kw:$(".search_header input[name=kw]").val(),
                    sort_field:this.sort_field,
                    sort:this.sort,
                    p:that.p
                };

                $.ajax({
                    url:common_ops.buildMUrl( "/product/search" ),
                    type:'GET',
                    dataType:'json',
                    data:data,
                    success:function( res ){
                        process = true;
                        if(res.code !== 0){
                            return;
                        }
                        var html = "";
                        for(idx in res.data){
                            var info = res.data[ idx ];
                            html += '<li> <a href="' + common_ops.buildMUrl( "/product/info", {id:info['id']}) + '"> <i><img src="/storage/'+ info['main_image_url'] +'"  style="width: 100%;height: 200px;"/></i> <span>'+ info['name'] +'</span> <b><label>月销量&nbsp;' + info['month_count'] +'</label>¥' + info['price'] +'</b> </a> </li>';
                        }

                        $(".probox ul.prolist").append( html );
                        if( !res.has_next ){
                            process = false;
                        }
                    }
                });
            }
        });
    },
    search:function (flag) {
        if (flag) {
            var sort_field = this.$_GET['sort_field'];
            var sort = this.$_GET['sort'];
            this.sort_field = sort_field;
            this.sort = sort;
        }
        var params = {
            kw:$('.search_header input[name=kw]').val(),
            sort_field:this.sort_field,
            sort:this.sort
        };

        window.location.href = common_ops.buildMUrl('/product', params);
    }

};

$(document).ready(function () {
    product_index_ops.init();
});