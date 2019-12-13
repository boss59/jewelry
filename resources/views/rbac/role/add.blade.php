@extends('layout.layout')

@section('title')
    角色 添加
@endsection


@section('content')
    <marquee><h2><font color='blue'>角色 添加</font></h2></marquee>
    <form class="layui-form layui-form-pane" action="{{ url("/admin/cate_add") }}" method="post" style="margin: 50px ;" id="form" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item" style="padding-left:400px">
            <label class="layui-form-label">角色名</label>
            <div class="layui-input-inline">
                <input type="text" name="rname" required  lay-verify="required" placeholder="请输入分类名" autocomplete="off" class="layui-input">@php echo $errors->first('brand_name')@endphp
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:400px">
            <div class="layui-input-block">
                <input type="button" value="立即提交" class="btn btn-success" name="btn">
                <input type="reset" value="重置表单" class="btn btn-info">
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

        // 上传
        $(document).ready(function(){
            $("input[name='btn']").click(function(){
                // var form = new FormData($("#form")[0]);
                var form = $('#form').serialize();// 序列化serialize
                // alert(form);
                $.ajax({
                    url:"/admin/role_add",
                    data:form,
                    type:"POST",
                    dataType:'json',
                    // processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                    // contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                    success:function(res){
                        if (res == 1) {
                            alert("添加成功");
                            location.href="/admin/role_index";
                        }else{
                            alert("失败");
                        }
                    }
                })
            })
        })
    </script>
@endsection
