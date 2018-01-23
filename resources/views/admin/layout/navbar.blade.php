
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0);"><i class="fa fa-bars"></i> </a>

            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
						<span class="m-r-sm text-muted welcome-message">
                            欢迎使用编程浪子图书商城管理后台
                        </span>
                </li>
                <li class="hidden">
                    <a class="count-info" href="javascript:void(0);">
                        <i class="fa fa-bell"></i>
                        <span class="label label-primary">8</span>
                    </a>
                </li>


                <li class="dropdown user_info">
                    <a class="dropdown-toggle" data-toggle="dropdown"href="javascript:void(0);">
                        <img alt="image" class="img-circle" src="/images/web/avatar.png" />
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                {{$user->nickname}}                                    <a href="/admin/user/edit" class="pull-right">编辑</a>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                手机号码：{{$user->mobile}}                                </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="link-block text-center">
                                <a class="pull-left" href="/admin/user/reset-password">
                                    <i class="fa fa-lock"></i> 修改密码
                                </a>
                                <a class="pull-right" href="/admin/logout">
                                    <i class="fa fa-sign-out"></i> 退出
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>

        </nav>
    </div>

