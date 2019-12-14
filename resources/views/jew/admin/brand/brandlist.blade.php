@extends('layout.layout')

@section('title')
    品牌 展示
@endsection
@section('content')
        <div class="form-group">
            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
            <div class="input-group">
                <input type="text" name="brand_name" class="form-control" id="exampleInputAmount" placeholder="Amount">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="sou">搜素</button>
    <table class="table table-striped table-bordered table-hover" >
        <tr>
            <td>品牌id</td>
            <td>品牌名称</td>
            <td>品牌url</td>
            <td>品牌图片</td>
            <td>操作</td>
        </tr>
        <bobay id="list">
        @foreach($data as $k=>$v)
            <tr brand_id="{{$v['brand_id']}}">
                    <td >{{$v['brand_id']}}</td>
                    <td>{{$v['brand_name']}}</td>
                    <td>{{$v['brand_url']}}</td>
                    <td><img src="{{$v['brand_brand']}}" alt="" class="img-thumbnail" width="100" height="100"></td>
                    <td><button type="button" class="btn btn-danger del">删除</button>|<button type="button" class="btn btn-warning" id="updata">修改</button></td>
            </tr>
        @endforeach
            <tr align="center">
                <td colspan="7"><div id>{{ $data->links() }}</div></td>
            </tr>
        </bobay>
    </table>
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
            })
            // 分页
            $(document).on('click','#page a',function(){
                event.preventDefault();
                var url = $(this).attr('href');
                alet(url);return;
                page(url);
            })
            // 条件搜索
            $(document).on('click','#sou',function() {
                var url = "/admin/brandlist";
                page(url);
            })
            //方法
            function page(url)
            {
                var sou = $("input[name = 'brand_name']").val();
                $.ajax({
                    url:url,
                    dataType:"json",
                    data:{brand_name:sou},
                    type:"post",
                    success:function(res){
                        $("#list").empty();
                        $.each(res.data,function(k,v){
                            var tr = $(" <tr brand_id="+v.brand_id+"></tr>");// 创建 tr
                            tr.append("<td >"+v.brand_id+"</td>");
                            tr.append("<td >"+v.brand_name+"</td>");
                            tr.append("<td >"+v.brand_url+"</td>");
                            tr.append("<td >"+v.brand_img+"</td>");
                            tr.append("<td>"+"<button type='button' class='btn btn-danger del'>"+删除+"</button>"+"|<button type='button' class='btn btn-warning' id='updata'>"+修改+"</button>"+"</td>");
                        })
                        $('#list').html(res.page).css("color","blue");
                    }

                })
                $('#page').html(res.page);
            }
        })
    </script>
@endsection
