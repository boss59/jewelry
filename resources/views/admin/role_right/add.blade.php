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
<h2 align="center">角色 权限关系添加</h2>
<form method="post" action="/rbac/role_right_add">
    @csrf
    <table align="center">
        <tr>
            <td>角色名：</td>
            <td>
                <select name="role_id">
                    @foreach($role as $k=>$v)
                        <option value="{{ $v->role_id }}">{{ $v->rname }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>权限名：</td>
            <td>
                <select name="right_id" lay-verify="required" lay-search>
                    @foreach($rights as $k=>$v)
                        <option value="{{ $v->right_id }}">{{ $v->rig_name }}</option>
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