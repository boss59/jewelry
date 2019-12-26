<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        ul li {
            display: inline;
        }
    </style>
</head>
<body>
<h2 align="center">权限展示</h2>
<table align="center" border="1">
    <tr>
        <td>编号</td>
        <td>权限名</td>
        <td>添加时间</td>
    </tr>
    @foreach($index as $k=>$v)
        <tr>
            <td>{{ $v->right_id }}</td>
            <td>{{ $v->rig_name }}</td>
            <td>{{ date("Y-m-d H:i:s",$v->add_time) }}</td>
        </tr>
    @endforeach
        <tr align="center">
            <td colspan="6">{{ $index->links() }}</td>
        </tr>
</table>
</body>
</html>