@extends('layout.layout')

@section('title')
    商品 展示
@endsection

@section('content')
	<marquee><h2><font color='#8a2be2'>商品 展示</font></h2></marquee>
	
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

	<div style="padding-left:500px">
		<button class="btn btn-success"><a href="/goods/save">返回添加</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" class="btn btn-danger" id="delxx" value="批量删除">
	</div>
    <table class="layui-table" style="padding-left:300px"> 
    	<tr>
    		<td>
				<input type="checkbox" id="xxoo">全选<br />
				<input type="checkbox" id="noall">反选
			</td>
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
    		<td align="center" class="one">
				<input type="checkbox" name="one" value="{{$v['goods_id']}}">
				{{$v['goods_id']}}
			</td>
    		<td class="title">
				<span>{{$v['goods_name']}}</span>
				<input type="text" style="display:none;" />
			</td>

    		<td>{{$v['goods_article']}}</td>
    		<td>{{$v['cate_name']}}</td>
    		<td>{{$v['brand_name']}}</td>
    		<td>{{$v['goods_price']}}</td>
    		<td><img src="{{$v['goods_img']}}" width="70" height="50"></td>
    		<td>{{$v['goods_num']}}</td>
    		<td>{!! mb_substr($v->goods_desc,0,10)."……" !!}</td>
			{{--是否展示--}}
			@if($v['is_show'] == 1)
				<td align="center">
					<img src="{{ asset('static/yes/yes.gif') }}" class="is_show" is_show="0" width="30" height="30">
				</td>
			@else
				<td align="center">
					<img src="{{ asset('static/yes/no.gif') }}"  class="is_show" is_show="1" width="30" height="30">
				</td>
			@endif
			{{--是否新品--}}
			@if($v['is_new'] == 1)
				<td align="center">
					<img src="{{ asset('static/yes/yes.gif') }}" class="is_new" is_new="0" width="30" height="30">
				</td>
			@else
				<td align="center">
					<img src="{{ asset('static/yes/no.gif') }}"  class="is_new" is_new="1" width="30" height="30">
				</td>
			@endif
			{{--是否精品--}}
			@if($v['is_sell'] == 1)
				<td align="center">
					<img src="{{ asset('static/yes/yes.gif') }}" class="is_sell" is_sell="0" width="30" height="30">
				</td>
			@else
				<td align="center">
					<img src="{{ asset('static/yes/no.gif') }}"  class="is_sell" is_sell="1" width="30" height="30">
				</td>
			@endif
			{{--是否上架--}}
			@if($v['is_up'] == 1)
				<td align="center">
					<img src="{{ asset('static/yes/yes.gif') }}" class="is_up" is_up="0" width="30" height="30">
				</td>
			@else
				<td align="center">
					<img src="{{ asset('static/yes/no.gif') }}"  class="is_up" is_up="1" width="30" height="30">
				</td>
			@endif
    		<td>
    			<button type="button" class="layui-btn update">编辑</button><br /><br />
    			<button type="button" class="layui-btn del">删除</button>
    		</td>
    	</tr>
    	@endforeach
    	<tr align="center">
    		<td colspan="14">{{ $goods->appends($query)->links() }}</td>
    	</tr>
    </table>
<script>
	// 删除
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
	// 即点即改
	$(function(){
		// 全选
		$(document).on('click','#xxoo',function(){
			$('.one :checkbox').prop('checked',$(this).prop('checked'));
		});
		// 反选
		$(document).on('click','#noall',function(){
			$('.one :checkbox').prop('checked',function(i,val){
				return !val;
			});
		});

		// 即点即改 展示
		$(document).on('click','.is_show',function(){
			var data = {};
			data.is_show = $(this).attr('is_show');
			data.goods_id = $(this).parent().parent().attr('goods_id');
			console.log(data);
			var url = "/admin/judge";
			gai(data,url);
		});
		// 即点即改 新品
		$(document).on('click','.is_new',function(){
			var data = {};
			data.is_new = $(this).attr('is_new');
			data.goods_id = $(this).parent().parent().attr('goods_id');
			console.log(data);
			var url = "/admin/judge";
			gai(data,url);
		});
		// 即点即改 精品
		$(document).on('click','.is_sell',function(){
			var data = {};
			data.is_sell = $(this).attr('is_sell');
			data.goods_id = $(this).parent().parent().attr('goods_id');
			console.log(data);
			var url = "/admin/judge";
			gai(data,url);
		});
		// 即点即改 上架
		$(document).on('click','.is_up',function(){
			var data = {};
			data.is_up = $(this).attr('is_up');
			data.goods_id = $(this).parent().parent().attr('goods_id');
			console.log(data);
			var url = "/admin/judge";
			gai(data,url);
		});
		// ------------------修改名称--------------------------
		$(document).on('click','.title span',function(){
			var span = $(this);// 定义 span 标签
			var input = span.next();// 找 input 标签
			span.hide();// span 隐藏
			input.show(); // input 显示
			var name = span.html();// 获取 span 的值
			input.val(name);//放到 input里
			input.focus();//聚焦 input 标签
		})
		$(document).on('blur','.title input',function(){
			var input = $(this);//定义 input 标签
			var span = input.prev();// 找上一级 的 span
			input.hide();// span 隐藏
			span.show(); // input 显示
			var names = input.val();// 获取 input 的值
			span.text(names);// 放到 span 里
			var goods_id = input.parent().parent().attr("goods_id");//获取 id
			// alert(new_id);return;
			$.ajax({
				url:'/admin/judge',//请求地址
				type:'get',//请求的类型
				dataType:'json',//返回的类型
				data:{goods_name:names,goods_id:goods_id},//要传输的数据
				success:function(res){ //成功之后回调的方法
				}
			})
		});
		// -------------------批量删除-------------------------
		$(document).on('click','#delxx',function(){
			// 获取 选中的 input 的值
			var odj = $('.one :checked');
			var arr = new Array();// 定义数组
			// 循环 odj
			$.each(odj,function(){
				var id = $(this).val();
				arr.push(id);// 把id 放到数组中
			});
			if(confirm("是否确认删除")) {
				// 发送请求
				$.ajax({
					url: "/admin/del_all",//请求地址
					type: 'get',//请求的类型
					dataType: 'json',//返回的类型
					data: {goods_id: arr},//要传输的数据
					success: function (res) { //成功之后回调的方法
						window.location.reload();
					}
				})
			}
		});
		//========  方法即点即改   ===========
		function gai(data,url)
		{
			$.ajax({
				url:url,//请求地址
				type:'get',//请求的类型
				dataType:'json',//返回的类型
				data:data,//要传输的数据
				success:function(res){ //成功之后回调的方法
					if (res == 1) {
						window.location.reload();
					}
				}
			})
		}
	});
</script>
@endsection