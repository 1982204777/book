<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>管理后台</title>
    <link href="/css/web/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/web/style.css?ver=20170401" rel="stylesheet"></head>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>
<div id="wrapper">
    @include('admin.layout.nav')
    <div id="page-wrapper" class="gray-bg" style="background-color: #ffffff;">
    @include('admin.layout.navbar')
        @yield('content')
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="/js/web/user/edit.js"></script>
<script type="text/javascript" src="/js/web/user/reset_pwd.js"></script>
