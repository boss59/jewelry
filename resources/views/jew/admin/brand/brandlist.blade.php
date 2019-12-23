@extends('layout.layout')

@section('title')
    品牌 展示
@endsection
@section('content')
    <marquee><h2><font color='blue'>品牌 展示</font></h2></marquee>

    <form action="">
        <div class="layui-form-item" style="padding-left:450px">
            <label class="layui-form-label">商品名</label>
            <div class="layui-input-inline">
                <input type="text" name="brand_name" required  lay-verify="required" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="padding-left:420px">
            <div class="layui-input-block">
                <input type="button" value="立即搜索" class="btn btn-success" id="stn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-warning" ><a href="">返回添加</a></button>
            </div>
        </div>
    </form>

    <table class="layui-table" style="padding-left:300px">
        <tr>
            <td>品牌id</td>
            <td>品牌名称</td>
            <td>品牌url</td>
            <td>品牌图片</td>
            <td>操作</td>
        </tr>
        <tbody id="list">
            @foreach($list as $k=>$v)
                <tr brand_id="{{$v['brand_id']}}">
                        <td align="center">{{$v['brand_id']}}</td>
                        <td align="center">{{$v['brand_name']}}</td>
                        <td align="center"><a href="{{$v['brand_url']}}">链接地址</a></td>
                        <td align="center"><img src="{{$v['brand_brand']}}" alt="" class="img-thumbnail" width="70" height="50"></td>
                        <td align="center"><button type="button" class="btn btn-danger del">删除</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-warning" id="updata">修改</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
        <div align="center" id="page">
            {{ $list->appends($query)->links() }}
        </div>
    <script>
        $(document).ready(function(){
            // 单删
            $(".del").on('click',function(){
                var url = "/admin/branddel";
                var _this = $(this);
                var id = _this.parents('tr').attr('brand_id');
                $.ajax({
                    url:url,
                    dataType:"json",
                    data:{id:id},
                    type:"post",
                    success:function(res){
                        if(res == 1){
                            alert("成功");
                            location.href="/admin/brandlist";
                        }else{
                            alert("失败");
                            location.href="/admin/brandlist";
                        }
                    }
                })
            });
    //=============================================================================
            // 分页
            $(document).on('click','#page a',function(){
                event.preventDefault();
                var url = $(this).attr('href');
                page(url);
            });
            // 条件搜索
            $(document).on('click','#stn',function() {
                var url = "/admin/brandlist";
                page(url);
            })
            //方法
            function page(url)
            {
                var brand_name = $('input[name="brand_name"]').val();
                $.ajax({
                    url:url,//请求地址
                    type:'get',//请求的类型
                    dataType:'json',//返回的类型
                    data:{brand_name:brand_name},//要传输的数据
                    success:function(res){ //成功之后回调的方法
                        $('#list').empty();// 清空 list 区域

                        $.each(res.data, function(k,v) {
                            var tr = $("<tr brand_id='"+v.brand_id+"'></tr>");// 创建 tr
                            //数据
                            tr.append('<td align="center">'+v.brand_id+'</td>');
                            tr.append('<td align="center">'+v.brand_name+'</td>');
                            tr.append('<td align="center"><a href="'+v.brand_url+'">'+v.brand_url+'</a></td>');
                            tr.append('<td align="center"><img src="'+v.brand_brand+'" width="70" height="50"/></td>');

                            // 操作
                            tr.append('<td align="center"><button type="button" class="btn btn-danger del">删除</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-warning" id="updata">修改</button></td>');
                            $('#list').append(tr).css("color","blue");
                        })
                        $('#page').html(res.page);
                    }
                })
            }




        })
    </script>
@endsection
