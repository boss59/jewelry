@extends('layout.layout')

@section('title')
    管理员 修改
@endsection


@section('content')
    <form class="layui-form" action="{{ url("/admin/admin_update") }}" method="post" style="margin: 50px ;">
        <input type="hidden" name="user_id" value="{{ $data["user_id"] }}">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="uname" value="{{ $data["uname"] }}" required  lay-verify="required"  autocomplete="off" class="layui-input">@php echo $errors->first('uname')@endphp
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-inline">
                <input type="text" name="email" value="{{ $data["email"] }}" required  lay-verify="required"  autocomplete="off" class="layui-input">@php echo $errors->first('email')@endphp
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">电话</label>
            <div class="layui-input-inline">
                <input type="text" name="tel" value="{{ $data["tel"] }}" required  lay-verify="required"  autocomplete="off" class="layui-input">@php echo $errors->first('tel')@endphp
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="submit" value="立即修改" class="btn btn-success">
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
