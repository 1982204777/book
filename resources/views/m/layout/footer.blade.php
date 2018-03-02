<div class="footer_fixed clearfix">
    <span><a href="/m/home" class="{{request()->getPathInfo() == '/m/home' ? 'aon' : 'default'}}"><i class="home_icon"></i><b>首页</b></a></span>
    <span><a href="/m/product" class="{{request()->getPathInfo() == '/m/product' ? 'aon' : 'product'}}"><i class="store_icon"></i><b>图书</b></a></span>
    <span><a href="/m/user" class="{{substr(request()->getPathInfo(), 0, 7) == '/m/user' ? 'aon' : 'user'}}"><i class="member_icon"></i><b>我的</b></a></span>
</div>
<div class="layout_hide_wrap hidden">
    <input type="hidden" id="share_info" value="{{isset($share_info) ? $share_info : ''}}">
</div>
</body>
</html>
