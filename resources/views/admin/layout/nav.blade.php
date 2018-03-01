<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="profile-element text-center">
                    <img alt="image" class="img-circle" src="/images/web/logo.png" />
                    <p class="text-muted">编程浪子</p>
                </div>
                <div class="logo-element">
                    <img alt="image" class="img-circle" src="/images/web/logo.png" />
                </div>
            </li>
            <li class="dashboard">
                <a href="/web/dashboard/index"><i class="fa fa-dashboard fa-lg"></i>
                    <span class="nav-label">仪表盘</span></a>
            </li>
            <li class="account {{substr(request()->getPathInfo(), 0, 14) == '/admin/account' ? 'active' : ''}}">
                <a href="/admin/account"><i class="fa fa-user fa-lg"></i> <span class="nav-label">账号管理</span></a>
            </li>
            <li class="brand {{substr(request()->getPathInfo(), 0, 12) == '/admin/brand' ? 'active' : ''}}">
                <a href="/admin/brand/info"><i class="fa fa-cog fa-lg"></i> <span class="nav-label">品牌设置</span></a>
            </li>
            <li class="book {{substr(request()->getPathInfo(), 0, 11) == '/admin/book' ? 'active' : ''}}">
                <a href="/admin/book"><i class="fa fa-book fa-lg"></i> <span class="nav-label">图书管理</span></a>
            </li>
            <li class="member {{substr(request()->getPathInfo(), 0, 13) == '/admin/member' ? 'active' : ''}}">
                <a href="/admin/member"><i class="fa fa-group fa-lg"></i> <span class="nav-label">会员列表</span></a>
            </li>
            <li class="finance {{substr(request()->getPathInfo(), 0, 14) == '/admin/finance' ? 'active' : ''}}">
                <a href="/admin/finance"><i class="fa fa-rmb fa-lg"></i> <span class="nav-label">财务管理</span></a>
            </li>
            <li class="market {{substr(request()->getPathInfo(), 0, 13) == '/admin/qrcode' ? 'active' : ''}}">
                <a href="/admin/qrcode"><i class="fa fa-share-alt fa-lg"></i> <span class="nav-label">营销渠道</span></a>
            </li>
            <li class="stat {{substr(request()->getPathInfo(), 0, 11) == '/admin/stat' ? 'active' : ''}}">
                <a href="/admin/stat"><i class="fa fa-bar-chart fa-lg"></i> <span class="nav-label">统计管理</span></a>
            </li>
        </ul>

    </div>
</nav>