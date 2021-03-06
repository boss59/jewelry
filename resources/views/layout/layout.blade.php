<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="64300">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>商城后台</title>
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layui/layui.all.js') }}"></script>
    <script src="{{ asset('layui/layui.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('layui/css/layui.mobile.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('layui/css/layui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/canvas.css') }}">
    {{-- 应用部分 --}}
    <script src="{{ asset('bootstrap/js/img.js') }}"></script>
    <script src="{{ asset('snow.js') }}"></script>
    <script src="{{ asset('js/canvas.js') }}"></script>
</head>
<body class="layui-layout-body" >
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">
            <img src="/bootstrap/img/222.jpg" width="70" height='40'>全职&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;高手
        </div>

        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;控制台</a>
            </li>
            <li class="layui-nav-item"><a href="">
                    <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;商品管理</a></li>
            <li class="layui-nav-item"><a href="">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;邮件管理</a></dd>
                    <dd><a href="">
                            <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;消息管理</a></dd>
                    <dd><a href="">
                            <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="/bootstrap/img/111.jpg" class="layui-nav-img" width="50" height="50">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">
                            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;基本资料</a></dd>
                    <dd><a href="">
                            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;安全设置</a></dd>
                </dl>
            </li>
            @if(empty($info['uname']))
                <button type="button" class="btn btn-default"><a href="{{ url("/admin/login") }}">登陆</a></button>
            @else
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">{{$info['uname']}}</button>
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" >
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ url("/login/quit") }}">注销</a>
                        </li>
                    </ul>
                </div>
            @endif

        </ul>
    </div>
    <canvas id="canvas"></canvas>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            @section('slide')
                <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-success" href="javascript:;">
                            <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>&nbsp;&nbsp;
                            管理员 管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/admin_add">
                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>&nbsp;&nbsp;
                                    管理员 添加</a></dd>
                            <dd><a href="/admin/admin_index">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    管理员 列表</a></dd>
                        </dl>
                    </li>

                    {{--RBAC 管理--}}
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-info" href="javascript:;">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;
                            RBAC 管理系统</a>
                        <dl class="layui-nav-child">
                            {{--角色--}}
                            <dd><a href="{{ url("/admin/role_add") }}">
                                    <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    角色 添加</a></dd>
                            <dd><a href="{{ url("/admin/role_index") }}">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    角色 列表</a></dd>
                            {{--权限--}}
                            <dd><a href="{{ url("/admin/right_add") }}">
                                    <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    权限 添加</a></dd>
                            <dd><a href="{{ url("/admin/right_index") }}">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    权限 列表</a></dd>
                            {{--角色 admin关系表--}}
                            <dd><a href="{{ url("/admin/admin_role_add") }}">
                                    <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    角色 admin 添加</a></dd>
                            <dd><a href="{{ url("/admin/admin_role_index") }}">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    角色admin 列表</a></dd>
                            {{--角色 权限关系表--}}
                            <dd><a href="{{ url("/admin/role_right_add") }}">
                                    <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    角色权限 添加</a></dd>
                            <dd><a href="{{ url("/admin/role_right_index") }}">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    角色权限 列表</a></dd>
                        </dl>
                    </li>

                    {{-- 分类 管理 --}}
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-primary" href="javascript:;">
                            <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>&nbsp;&nbsp;
                            分类 管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="{{ url('/cate/add') }}">
                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>&nbsp;&nbsp;
                                    分类 添加</a></dd>
                            <dd><a href="{{ url('/cate/index') }}">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    分类 列表</a></dd>
                        </dl>
                    </li>

                    {{-- 品牌 管理 --}}
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-warning" href="javascript:;">
                            <span class="glyphicon glyphicon-align-center" aria-hidden="true"></span>&nbsp;&nbsp;
                            品牌 管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="{{ url('/admin/brand') }}">
                                    <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    品牌 添加</a></dd>
                            <dd><a href="{{ url('/admin/brandlist') }}">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    品牌 展示</a></dd>
                        </dl>
                    </li>
                    {{-- 商品 管理 --}}
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-danger" href="javascript:;">
                            <span class="glyphicon glyphicon-film" aria-hidden="true"></span>&nbsp;&nbsp;
                            商品 管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/goods/save">
                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>&nbsp;&nbsp;
                                    商品 添加</a></dd>
                            <dd><a href="/goods/show">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    商品 展示</a></dd>
                            <dd><a href="{{ url('/type/index') }}">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    属性 展示</a></dd>
                        </dl>
                    </li>



                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-default" href="javascript:;">
                            <span class="glyphicon glyphicon-header" aria-hidden="true"></span>&nbsp;&nbsp;
                            多文件 管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/img/create">
                                    <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    多文件 添加</a></dd>
                            <dd><a href="/img/index">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    多文件 列表</a></dd>
                        </dl>
                    </li>

                    {{--<li class="layui-nav-item layui-nav-itemed">--}}
                        {{--<a class="label label-success" href="javascript:;">--}}
                            {{--<span class="glyphicon glyphicon-flash" aria-hidden="true"></span>&nbsp;&nbsp;--}}
                            {{--新闻 管理</a>--}}
                        {{--<dl class="layui-nav-child">--}}
                            {{--<dd><a href="/admin/product_add">--}}
                                    {{--<span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;--}}
                                    {{--新闻 添加</a></dd>--}}
                            {{--<dd><a href="/admin/product_index">--}}
                                    {{--<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;--}}
                                    {{--新闻 列表</a></dd>--}}
                        {{--</dl>--}}
                    {{--</li>--}}

                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-primary" href="javascript:;">
                            <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>&nbsp;&nbsp;
                            友链 管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/friend/add">
                                    <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    友链 添加</a></dd>
                            <dd><a href="/friend/index">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                    友链 列表</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="label label-primary" href="javascript:;">
                            <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>&nbsp;&nbsp;
                            前台 管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/order/order">
                                    <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>&nbsp;&nbsp;
                                    订单 展示</a></dd>
                            <dd><a href="/admin/index">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp;&nbsp;
                                     展示 </a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="javascript:;">
                            <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>&nbsp;&nbsp;
                            云市场</a></li>
                    <li class="layui-nav-item"><a href="javascript:;">
                            <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>&nbsp;&nbsp;
                            发布商品</a></li>
                </ul>
            @show
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        @yield('content')
    </div>

    <div class="layui-footer" >
        <!-- 底部固定区域 -->
        <p align="center">
            <marquee><h2><font color="blue">每一个不甘离开，都是为了最后的归来！！！</font></h2></marquee>
        </p>
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;
    });
</script>
</body>
</html>