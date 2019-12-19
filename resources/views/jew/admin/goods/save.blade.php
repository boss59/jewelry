@extends('layout.layout')

@section('title')
    商品 添加
@endsection

@section('content')
    <marquee><h2><font color='blue'>商品 添加</font></h2></marquee>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="javascript:;" name='basic'>基本信息</a></li>
        <li role="presentation" ><a href="javascript:;" name='attr'>商品属性</a></li>
        <li role="presentation" ><a href="javascript:;" name='detail'>商品详情</a></li>
    </ul>

    <form class="layui-form layui-form-pane" style="margin: 50px ;" id="form" enctype="multipart/form-data">
        @csrf
        <div class="div_basic div_form">
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">商品名称</label>
            <div class="layui-input-inline">
                <input type="text" name="goods_name" required  lay-verify="required" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">商品号</label>
            <div class="layui-input-inline">
                <input type="text" name="goods_article" required  lay-verify="required" placeholder="请输入商品号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">分类名</label>
            <div class="layui-input-block" >
                <select name="cate_id" lay-verify="required" lay-search>
                    <option value="0">请选择。。。</option>
                    @foreach ($cate as $v)
                        <option value="{{$v['cate_id']}}">{!! str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$v["level"]-1).$v["cate_name"] !!}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">品牌名</label>
            <div class="layui-input-inline">
                <select name="brand_id" lay-verify="required" lay-search>
                    <option value="0">请选择。。。</option>
                    @foreach ($brand as $v)
                        <option value="{{$v['brand_id']}}">{{$v['brand_name']}}</option>
                    @endforeach

                </select>
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-block" >
                <input type="radio" name="is_show" value="1" title="是" checked>
                <input type="radio" name="is_show" value="0" title="否">
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">是否新品</label>
            <div class="layui-input-block" >
                <input type="radio" name="is_new" value="1" title="是" checked>
                <input type="radio" name="is_new" value="0" title="否">
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">是否精品</label>
            <div class="layui-input-block" >
                <input type="radio" name="is_sell" value="1" title="是" checked>
                <input type="radio" name="is_sell" value="0" title="否">
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">是否上架</label>
            <div class="layui-input-block" >
                <input type="radio" name="is_up" value="1" title="是" checked>
                <input type="radio" name="is_up" value="0" title="否" >
            </div>
        </div>
        
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">商品价格</label>
            <div class="layui-input-inline">
                <input type="text" name="goods_price" required  lay-verify="required" placeholder="请输入商品价格" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="form-group" style="padding-left:300px">
            <label class="layui-form-label ">商品图片</label>
            <input type="file" class="form-control" placeholder="" name="goods_img" style="display: none" id="upload">
            <button class="btn btn-warning" id="img" type="button" >上传图片</button>
            <div for="inputPassword3" class="col-sm-2 control-label">
                <img src="{{ asset('/bootstrap/img/222.jpg') }}" alt="图片" class="img-thumbnail" width="200" height="200">
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px">
            <label class="layui-form-label">商品库存</label>
            <div class="layui-input-inline">
                <input type="text" name="goods_num" required  lay-verify="required" placeholder="请输入商品库存" autocomplete="off" class="layui-input">
            </div>
        </div>
        {{--<div class="layui-form-item layui-form-text" style="padding-left:300px">--}}
            {{--<label class="layui-form-label">商品说明</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<textarea id="container" name="goods_desc"  class="layui-textarea"></textarea>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--========================   商品说明  ==============================--}}
        </div>
        <div class='div_detail div_form' style='display:none'>
            <div class="form-group">
                <label for="exampleInputFile">商品详情</label>
                <textarea class="form-control" name="goods_desc" rows="3"></textarea>
            </div>
        </div>

        <div class='div_attr div_form' style='display:none'>
        {{-------------------  商品属性  --------------------------------------}}
        <div class="layui-form-item" style="padding-left:300px;">
            <label class="layui-form-label">商品名</label>
            <div class="layui-input-inline">
                <select name="goods_id" lay-verify="required" lay-search>
                    <option value="0">请选择。。。</option>
                    @foreach ($goods as $v)
                        <option value="{{$v['goods_id']}}">{{$v['goods_id']}}   {{$v['goods_name']}}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:300px; ">
            <label class="layui-form-label">类型名</label>
            <div class="layui-input-inline">
                <select name="type_id"  lay-search id="aa" lay-filter="check_info">
                    <option value="0">请选择。。。</option>
                    @foreach ($type as $v)
                        <option  value="{{$v['type_id']}}">{{$v['type_id']}}     {{$v['type_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item" style="padding-left:300px; ">
            <label class="layui-form-label">属性名</label>
            <div class="layui-input-block" lay-filter="group">
                <select name="value_id"  lay-search id="list"  lay-verify="select">



                </select>
            </div>
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

        //属性值
        layui.use(['form'], function() {
            form=layui.form;
            form.on('select(check_info)', function(data){
                var type_id =data.value;
                $.ajax({
                    url:"/value/value",
                    data:{type_id:type_id},
                    type:"POST",
                    dataType:'json',
                    //processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                    //contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                    success:function(res){
                       $('#list').empty();
                       $.each(res,function (k,v) {
                           console.log(v);
                           $('#list').append("<option  value="+v.value_id+">"+v.value_id+"     "+v.value_name+"</option>");
                       });
                       form.render("select");
                    }
                })

            });
        });




        $(".nav-tabs a").on("click",function(){
            $(this).parent().siblings('li').removeClass('active');
            $(this).parent().addClass('active');
            var name = $(this).attr('name');  // attr basic
            $(".div_form").hide();
            $(".div_"+name).show();  // $(".div_"+name)
        });

        // 上传
        $(document).ready(function(){
            $("input[name='btn']").click(function(){
                var form = new FormData($("#form")[0]);

                // var form = $('#form').serialize();// 序列化serialize
                // alert(form);
                $.ajax({
                    url:"/goods/save_do",
                    data:form,
                    type:"POST",
                    dataType:'json',
                    processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                    contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                    success:function(res){
                        if (res.code == 1) {
                            alert(res.msg);
                            location.href="/goods/show";
                        }else{
                            alert(res.msg);
                        }
                    }
                })
            })
        });



        //
    </script>
@endsection
