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
<h2>注册</h2>
<form method="post" action="/rbac/regist">
    @csrf
   <table align="center">
       <tr>
           <td>用户名：</td>
           <td><input type="text" name="uname"></td>
       </tr>
       <tr>
           <td>密码：</td>
           <td><input type="password" name="pwd"></td>
       </tr>
       <tr>
           <td colspan="2" align="center"><input type="submit"></td>
       </tr>
   </table>
</form>

</body>
</html>