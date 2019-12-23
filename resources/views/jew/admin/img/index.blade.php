@extends('layout.layout')

@section('title')
多文件 展示
@endsection

@section('content')
<marquee><h2><font color='#8a2be2'>文件商品 展示</font></h2></marquee>

<div style="padding-left:500px">
    <button class="btn btn-success"><a href="/img/create">返回添加</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<table class="layui-table" style="padding-left:300px">
    <tr align="center">
        <td>ID</td>
        <td>商品ID</td>
        <td>文件图片</td>
        <td>文件图片说明</td>
        <td>操作</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr id="{{$v['id']}}" align="center">
        <td>{{$v['id']}}</td>
        <td>{{$v['goods_id']}}</td>
        <td><img src="{{$v['img_url']}}" width="70" height="50"></td>
        <td>{{$v['img_desc']}}</td>
        <td>
            <button type="button" class="layui-btn update">编辑</button><br /><br />
            <button type="button" class="layui-btn del">删除</button>
        </td>
    </tr>
    @endforeach
    <tr align="center">
        <td colspan="14">{{ $data->links() }}</td>
    </tr>
</table>
<script>
    // 删除
    $('.del').click(function(){
        var _this=$(this);
        if(confirm("是否确认删除")){
            var id=_this.parents('tr').attr('id');
            $.ajax({
                url:"/img/del",
                data:{id:id},
                type:'POST',
                dataType:'json',
                success:function(res){
                    if (res.code==1) {
                        window.location.reload();
                    }else{
                        alert(res.msg);
                    }
                }
            });
        };
    })
</script>
@endsection