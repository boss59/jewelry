@extends('layout.layout')

@section('title')
    品牌 添加
@endsection



@section('content')
    <marquee><h2><font color='blue'>品牌 添加</font></h2></marquee>
    <form class="layui-form layui-form-pane"   style="margin: 50px ;" id="form" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">品牌名称</label>
            <div class="layui-input-inline">
                <input type="text" name="brand_name" required  lay-verify="required" placeholder="请输入品牌" autocomplete="off" class="layui-input">@php echo $errors->first('brand_name')@endphp
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">品牌url</label>
            <div class="layui-input-inline">
                <input type="text" name="brand_url" required  lay-verify="required" placeholder="请输入路径" autocomplete="off" class="layui-input">@php echo $errors->first('brand_url')@endphp
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-block" >
                <input type="radio" name="brand_show" value="1" title="是" checked>
                <input type="radio" name="brand_show" value="0" title="否" >
            </div>
        </div>
        <div class="form-group" style="padding-left:300px">
            <label class="layui-form-label ">新闻图片</label>
            <input type="file" class="form-control" placeholder="" name="brand_brand" style="display: none" id="upload">
            <button class="btn btn-warning" id="img" type="button" >上传图片</button>
            <div for="inputPassword3" class="col-sm-2 control-label">
                <img src="{{ asset('/bootstrap/img/222.jpg') }}" alt="图片" class="img-thumbnail" width="200" height="200">
            </div>
        </div>
        <br><br>
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
                $.ajax({
                    url:"/admin/brandadd",
                    data:form,
                    type:"POST",
                    dataType:'json',
                    // jsonp:"callback",
                    processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                    contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                    success:function(res){
                        if (res == 1) {
                            alert("成功");
                            location.href="/admin/brandlist";
                        }else{
                            alert("失败");
                        }
                    }
                })
            })
        })
    </script>
@endsection
