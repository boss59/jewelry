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
<h2 align="center">admin 角色展示</h2>
<table align="center" border="1">
    <thead>
        <tr>
            <th>序号</th>
            <th>用户名</th>
            <th>role号</th>
            <th>角色名</th>
            <th>时间</th>
        </tr>
    </thead>
    <tbody>
    @foreach($index as $k=>$v)
        <tr>
            <td>{{ $v->user_id }}</td>
            <td>{{ $v->uname }}</td>
            <td>{{ $v->role_id }}</td>
            <td>{{ $v->rname }}</td>
            <td>{{ date("Y-m-d H:i:s",$v->add_time) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tr align="center">
        <td colspan="6">{{ $index->links() }}</td>
    </tr>
</table>
</body>
</html>