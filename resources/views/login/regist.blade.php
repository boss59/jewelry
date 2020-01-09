<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layui/layui.all.js') }}"></script>
    <script src="{{ asset('layui/layui.js') }}"></script>
</head>
<body>
<h2 align="center">注册</h2>

    @csrf
    <table align="center">
        <tr>
            <td>用户名：</td>
            <td><input type="text" name="uname" ></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input type="password" name="pwd" ></td>
        </tr>
        <tr>
            <td>验证码：</td>
            <td>
                <input type="text" name="code">
                <input type="button" name="yan" value="发送验证码">
                <h2 id="code"></h2>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" name="btn" value="立即注册">
            </td>
        </tr>
    </table>


</body>
</html>
<script>
    $(document).ready(function(){
        //注册
        $("input[name='btn']").click(function(){
            var data = {};// 定义一个空的json串
            data.uname  = $("input[name='uname']").val();
            data.pwd  = $("input[name='pwd']").val();
            data.code  = $("input[name='code']").val();
            if (data.code === ""){
                alert('请先输入验证码');return;
            }
            $.ajax({
                url:'/login/regist',//请求地址
                type:'post',//请求的类型
                dataType:'json',//返回的类型
                data:data,//要传输的数据
                success:function(res){ //成功之后回调的方法
                    if (res.code == 0) {
                        alert(res.msg);
                    }else{
                        alert(res.msg);
                        location.href = "/login/login";
                    }
                }
            })
        });

        // 发送验证码
        $("input[name='yan']").click(function(){

            $.ajax({
                url:'/login/yan',//请求地址
                type:'get',//请求的类型
                success:function(res){ //成功之后回调的方法
                    $('#code').text(res);
                }
            })
        });
    });



</script>
