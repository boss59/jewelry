@extends('layout.layout')

@section('title')
    多文件 添加
@endsection

@section('content')
    <marquee><h2><font color='blue'>多文件 添加</font></h2></marquee>
    <form class="layui-form layui-form-pane" style="margin: 50px ;" id="form" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">商品名称</label>
            <div class="layui-input-block" >
                <select name="goods_id" lay-verify="required" lay-search>
                    <option value="">请选择---</option>
                @foreach($goods as $k=>$v)
                        <option value="{{ $v['goods_id'] }}">{{ $v['goods_id'] }}.{{ $v['goods_name'] }}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="form-group" style="padding-left:300px">
            <label class="layui-form-label ">商品图片</label>
            <input type="file" class="form-control" placeholder="" name="img_url" style="display: none" id="upload">
            <button class="btn btn-warning" id="img" type="button" >上传图片</button>
            <div for="inputPassword3" class="col-sm-2 control-label">
                <img src="{{ asset('/bootstrap/img/222.jpg') }}" alt="图片" class="img-thumbnail" width="200" height="200">
            </div>
        </div>
        <div class="layui-form-item layui-form-text" style="padding-left:300px">
            <label class="layui-form-label">商品说明</label>
            <div class="layui-input-block">
                <textarea id="container" name="img_desc"  class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:300px">
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
                var form = new FormData($("#form")[0]);
                // var form = $('#form').serialize();// 序列化serialize
                // alert(form);
                $.ajax({
                    url:"/img/save",
                    data:form,
                    type:"POST",
                    dataType:'json',
                    processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                    contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                    success:function(res){
                        if (res.code == 1) {
                            alert(res.msg);
                            location.href="/img/index";
                        }else{
                            alert(res.msg);
                        }
                    }
                })
            })
        })
    </script>
@endsection
