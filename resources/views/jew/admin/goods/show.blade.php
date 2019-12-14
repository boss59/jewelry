@extends('layout.layout')

@section('title')
    商品 展示
@endsection

@section('content')
	<marquee><h2><font color='green'>商品 展示</font></h2></marquee>
	
	<form action="/goods/show" method="get" class="layui-table" style="padding-left:100px">
		<table class="layui-table" style="padding-left:300px">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				商品名称：<input type="text" name="goods_name">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				分类名：
						<select name="cate_id" lay-verify="required" lay-search >
							<option value="">请选择---</option>
							@foreach ($cate as $v)
	                        	<option value="{{$v['cate_id']}}">{!! str_repeat("&nbsp;",$v['level']*4)!!}{{$v['cate_name']}}</option>
	                    	@endforeach
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


				品牌名：
						<select name="brand_id" lay-verify="required" lay-search>
							<option value="">请选择---</option>
							@foreach ($brand as $v)
                        		<option value="{{$v['brand_id']}}">{{$v['brand_name']}}</option>
                    		@endforeach
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				是否上架：
						<select name="is_up" lay-verify="required" lay-search>
							<option value="">请选择---</option>
							<option value="0">未上架</option>
							<option value="1">上架</option>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


						<input type="submit" value="搜索" class="btn btn-success">

		</table>
	</form>
	
    <table class="layui-table" style="padding-left:300px"> 
    	<tr>
    		<td>商品ID</td>
    		<td>商品名称</td>
    		<td>商品号</td>
    		<td>分类名</td>
    		<td>品牌名</td>
    		<td>商品价格</td>
    		<td>商品图片</td>
    		<td>商品库存</td>
    		<td>商品说明</td>
    		<td>是否展示</td>
    		<td>是否新品</td>
    		<td>是否精品</td>
    		<td>是否上架</td>
    		<td>操作</td>
    	</tr>
    	@foreach($goods as $k=>$v)
    	<tr goods_id="{{$v['goods_id']}}">
    		<td>{{$v['goods_id']}}</td>
    		<td>{{$v['goods_name']}}</td>
    		<td>{{$v['goods_article']}}</td>
    		<td>{{$v['cate_name']}}</td>
    		<td>{{$v['brand_name']}}</td>
    		<td>{{$v['goods_price']}}</td>
    		<td><img src="{{$v['goods_img']}}"></td>
    		<td>{{$v['goods_num']}}</td>
    		<td>{{$v['goods_desc']}}</td>
    		<td>@if($v['is_show'] == '0')否@else是@endif</td>
    		<td>@if($v['is_new'] == '0')否@else是@endif</td>
    		<td>@if($v['is_sell'] == '0')否@else是@endif</td>
    		<td>@if($v['is_up'] == '0')否@else是@endif</td>
    		<td>
    			<button type="button" class="layui-btn update">编辑</button><br /><br />
    			<button type="button" class="layui-btn del">删除</button>
    		</td>
    	</tr>
    	@endforeach
    	<tr align="center">
    		<td colspan="14">{{ $goods->links() }}</td>
    	</tr>
    </table>
<script>
    $('.del').click(function(){
      var _this=$(this);
      if(confirm("是否确认删除")){
        var goods_id=_this.parents('tr').attr('goods_id');
        $.ajax({
          url:"/goods/del",
          data:{goods_id:goods_id},
          type:'POST',
          dataType:'json',
          success:function(res){
            if (res.code==1) {
               alert(res.msg);
               _this.parents('tr').remove();
            }else{
              alert(res.msg);
            }
          }
        });
      };
    })
</script>
@endsection