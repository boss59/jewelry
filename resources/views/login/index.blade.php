<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登陆</title>
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layui/layui.all.js') }}"></script>
    <script src="{{ asset('layui/layui.js') }}"></script>
</head>
<body>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>首页</title>
</head>
<body>
<h2 align="center">首页</h2><br /><br />
<h2 align="center">{{ $info }}</h2><br /><br />

<h3 align="center"><a href="/rbac/role_add">角色添加</a></h3>
<h3 align="center"><a href="/rbac/role_index">角色展示</a></h3>
<h3 align="center"><a href="/rbac/right_add">权限添加</a></h3>
<h3 align="center"><a href="/rbac/right_index">权限展示</a></h3>
<h3 align="center"><a href="/rbac/admin_role_add">admin 角色关系添加</a></h3>
<h3 align="center"><a href="/rbac/admin_role_index">admin 角色关系展示</a></h3>
<h3 align="center"><a href="/rbac/role_right_add">角色 权限关系添加</a></h3>
<h3 align="center"><a href="/rbac/role_right_index">角色 权限关系展示</a></h3>



</body>
</html>

</body>
</html>

