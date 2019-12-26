<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2 align="center">admin 角色关系添加</h2>
<form method="post" action="/rbac/admin_role_add">
    @csrf
    <table align="center">
        <tr>
            <td>用户名：</td>
            <td>
                <select name="user_id">
                    @foreach($admin as $k=>$v)
                        <option value="{{ $v->user_id }}">{{ $v->uname }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>角色名：</td>
            <td>
                <select name="role_id" >
                    @foreach($role as $k=>$v)
                        <option value="{{ $v->role_id }}">{{ $v->rname }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"></td>
        </tr>
    </table>
</form>

</body>
</html>