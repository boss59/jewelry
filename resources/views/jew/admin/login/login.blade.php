<!DOCTYPE html>
<html>
<head>

    <title>登录表单</title>
    <base href="/static/login/">
    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.8.3/jquery.js"></script>
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<script type="text/javascript">(function($){$.fn.snow = function(options){var $flake = $('<div id="snowbox" />').css({'position': 'absolute','z-index':'9999', 'top': '-50px'}).html('&#10052;'),documentHeight = $(document).height(),documentWidth= $(document).width(),defaults = {minSize: 10,maxSize: 20,newOn: 1000,flakeColor: "#AFDAEF" /* 此处可以定义雪花颜色，若要白色可以改为#FFFFFF */},options= $.extend({}, defaults, options);var interval= setInterval( function(){var startPositionLeft = Math.random() * documentWidth - 100,startOpacity = 0.5 + Math.random(),sizeFlake = options.minSize + Math.random() * options.maxSize,endPositionTop = documentHeight - 200,endPositionLeft = startPositionLeft - 500 + Math.random() * 500,durationFall = documentHeight * 10 + Math.random() * 5000;$flake.clone().appendTo('body').css({left: startPositionLeft,opacity: startOpacity,'font-size': sizeFlake,color: options.flakeColor}).animate({top: endPositionTop,left: endPositionLeft,opacity: 0.2},durationFall,'linear',function(){$(this).remove()});}, options.newOn); };})(jQuery);$(function(){ $.fn.snow({ minSize: 5, /* 定义雪花最小尺寸 */ maxSize: 50,/* 定义雪花最大尺寸 */ newOn: 300 /* 定义密集程度，数字越小越密集 */ });});</script>
<h1>登录表单</h1>
{{--登录--}}
<div class="container w3layouts agileits">
    <div class="login w3layouts agileits">
        <h2>登 录</h2>
        <form action="{{ url("admin/login") }}" method="post">
            @csrf
                <input type="text" Name="uname" class="uname" placeholder="用户名" required="required"> @php echo $errors->first('phone')@endphp
            <input type="password" Name="pwd" class="pwd" placeholder="密码" required="required"> @php echo $errors->first('phone')@endphp
            <ul class="tick w3layouts agileits">
                <li>
                    <input type="checkbox" id="brand1" name="remember" value="1">
                    <label for="brand1"><span></span>三天免登陆</label>
                </li>
            </ul>
            <div class="send-button w3layouts agileits">
                    <input type="button" value="登 录" id="btns">
            </div>
        </form>
            <a href="#">忘记密码?</a>
            <div class="social-icons w3layouts agileits">
                <p>- 其他方式登录 -</p>
                <ul>
                    <li class="qq"><a href="#">
                            <span class="icons w3layouts agileits"></span>
                            <span class="text w3layouts agileits">QQ</span></a></li>
                    <li class="weixin w3ls"><a href="/admin/user">
                            <span class="icons w3layouts"></span>
                            <span class="text w3layouts agileits">微信</span></a></li>
                    <li class="weibo aits"><a href="#">
                            <span class="icons agileits"></span>
                            <span class="text w3layouts agileits">微博</span></a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
        <div class="clear"></div>
    </div>

    {{--注 册--}}
    <div class="register w3layouts agileits">
        <h2>注 册</h2>
        <form action="{{ url("/admin/regist") }}" method="post">
            @csrf
                <input type="text" Name="uname" id="uname" placeholder="用户名" required="required">
                <input type="text" Name="email" id="email" placeholder="邮箱" required="required">
                <input type="password" Name="pwd" id="pwd" placeholder="密码" required="required">
                <input type="text" Name="tel" id="tel" placeholder="手机号码" required="required">
            <div class="send-button w3layouts agileits">
                    <input type="button" value="免费注册" name="btn">
            </div>
        </form>

        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>


<div class="footer w3layouts agileits">
    <p>
        <a href="http://www.cssmoban.com/" target="_blank" title="全职高手">全职高手</a>&nbsp;&nbsp;之&nbsp;&nbsp;
        <a href="http://www.cssmoban.com/" target="_blank" title="巅峰荣耀">巅峰荣耀</a>
    </p>
</div>

</body>
</html>
<script>
    // 注册
    $(document).ready(function(){
        $("input[name='btn']").click(function(){
            var data = {};
            data.uname = $('#uname').val();
            data.pwd = $('#pwd').val();
            data.email = $('#email').val();
            data.tel = $('#tel').val();
            $.ajax({
                url:"/admin/regist",
                data:data,
                type:"POST",
                dataType:'json',
                //processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                //contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                success:function(res){
                    if (res.code == 1) {
                        alert(res.msg);
                        location.href="/admin/index";
                    }else{
                       alert(res.msg);
                    }
                }
            })
        });
    });
    // 登陆
    $(document).ready(function(){
        $("#btns").click(function(){
            var data = {};
            data.uname = $('.uname').val();
            data.pwd = $('.pwd').val();
            // console.log(data);return;
            $.ajax({
                url:"/admin/login",
                data:data,
                type:"POST",
                dataType:'json',
                //processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                //contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                success:function(res){
                    if (res.res==1) {
                        alert(res.font);
                        location.href="/admin/index";
                    }else{
                        alert(res.font);
                    }
                }
            })
        });
    });
</script>
