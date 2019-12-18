@extends('layout.layout')

@section('title')
    类型值
@endsection

@section('content')


    <form class="layui-form layui-form-pane" action="javascript:;" style="margin: 50px ;" id="form" enctype="multipart/form-data">
        @csrf


        <div class="layui-form-item">
            <label class="layui-form-label">类型</label>
            <div class="layui-input-block">
                <select name="type_id" id="se" lay-verify="required">
                    @foreach ($data as $v)
                        <option value="{{$v->type_id}}">{{$v->type_id}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$v->type_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">类型值</label>
            <div class="layui-input-block">
                <input type="text" name="value_name" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="button" value="立即提交" class="btn btn-success" lay-submit id="btn" name="btn">
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

        // $(document).on('click',"#btn",function(){

        $("input[name='btn']").click(function(){
            // var form = new FormData($("#form")[0]);
            var form = $('#form').serialize();// 序列化serialize
            $.ajax({
                url:"/type/value",
                data:form,
                type:"POST",
                dataType:'json',
                //processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                //contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                success:function(res){
                    // alert(111);return;
                    if (res.code == 1) {
                        alert(res.msg);
                        location.href="/type/index";
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })

        // });
    </script>
@endsection