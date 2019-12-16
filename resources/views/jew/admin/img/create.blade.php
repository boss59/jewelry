@extends('layout.layout')

@section('title')
    多文件 添加
@endsection

@section('content')
    <marquee><h2><font color='blue'>多文件 添加</font></h2></marquee>
    <form method="post" action="/img/create" class="layui-form layui-form-pane" style="margin: 50px ;" id="form" enctype="multipart/form-data">
        @csrf

        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">商品名称</label>
            <div class="layui-input-block" >
                <select name="cate_id" lay-verify="required" lay-search>
                    <option value="">请选择。。。</option>
                @foreach($goods as $k=>$v)
                        <option value="{{ $v['goods_id'] }}">{{ $v['goods_id'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ $v['goods_name'] }}</option>
                @endforeach
                </select>
            </div>
        </div>


        <div class="form-group" style="padding-left:300px">
            <div class="file-field">
                <a href="javascript:;" onclick="addImg(this)">[+]</a>
                图片描述 <input type="text" name="img_desc[]" size="20"><br />
                上传文件 <input type="file" name="img_url[]"><br />
            </div>
        </div>






        <div class="layui-form-item" style="padding-left:300px">
            <div class="layui-input-block">
                <input type="submit" value="立即提交" class="btn btn-success" name="btn">
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


    </script>
@endsection
