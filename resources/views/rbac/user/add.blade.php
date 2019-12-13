@extends('layout.layout')

@section('title')
    管理员 添加
@endsection


@section('content')
    <form class="layui-form layui-form-pane" action="{{ url("/admin/admin_add") }}" method="post" style="margin: 50px ;">
        @csrf
        <div class="layui-form-item" style="padding-left:400px">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="uname" required  lay-verify="required" placeholder="请输入管理员姓名" autocomplete="off" class="layui-input">@php echo $errors->first('uname')@endphp
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:400px">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="pwd" required  lay-verify="required" placeholder="请输入管理员密码" autocomplete="off" class="layui-input">@php echo $errors->first('pwd')@endphp
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:400px">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-inline">
                <input type="text" name="email" required  lay-verify="required" placeholder="请输入管理员邮箱" autocomplete="off" class="layui-input">@php echo $errors->first('email')@endphp
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:400px">
            <label class="layui-form-label">电话</label>
            <div class="layui-input-inline">
                <input type="text" name="tel" required  lay-verify="required" placeholder="请输入管理员电话" autocomplete="off" class="layui-input">@php echo $errors->first('tel')@endphp
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:400px">
            <div class="layui-input-block">
                <input type="submit" value="立即提交" class="btn btn-success">
                <input type="reset" value="重置" class="btn btn-info">
            </div>
        </div>
    </form>

    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form;
            //监听提交
            form.on('submit(formDemo)', function(data){
                layer.msg(JSON.stringify(data.field));
                return false;
            });
        });
    </script>
@endsection
