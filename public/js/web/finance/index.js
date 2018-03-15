;
var finance_index_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.wrap_search select[name=status]').change(function () {
            $(".wrap_search").submit();
        });
    }
};

$(document).ready(function () {
    finance_index_ops.init();
});