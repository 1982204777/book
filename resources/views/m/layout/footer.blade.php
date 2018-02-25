<div class="copyright clearfix">
    @if(isset($user))
    <p class="name">欢迎您，{{$user->nickname}}</p>
    @endif
        <p class="copyright">由<a href="/" target="_blank">王庆銮</a>提供技术支持</p>
</div>
<div class="footer_fixed clearfix">
    <span><a href="/m/home" class="{{request()->getPathInfo() == '/m/home' ? 'aon' : 'default'}}"><i class="home_icon"></i><b>首页</b></a></span>
    <span><a href="/m/product" class="{{request()->getPathInfo() == '/m/product' ? 'aon' : 'product'}}"><i class="store_icon"></i><b>图书</b></a></span>
    <span><a href="/m/user" class="{{request()->getPathInfo() == '/m/user' ? 'aon' : 'user'}}"><i class="member_icon"></i><b>我的</b></a></span>
</div>

</body>
</html>
