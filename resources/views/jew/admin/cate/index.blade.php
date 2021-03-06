
@extends('layout.layout')
@section('title')
    分类展示
@endsection


@section('content')
<marquee><h2><font color='blue'>分类 展示</font></h2></marquee>

<table class="layui-table" style="width: 600px; margin-left:300px; margin-top: 50px;" >
  <thead>
    <tr>
      <th>编号</th>
      <th>昵称</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
    @foreach ($data as $v)
    <tr cate_id="{{$v->cate_id}}" parent_id="{{$v->parent_id}}">
      <td><button class="btn">+</button></td>
    
      <td>{!! str_repeat("&nbsp;",$v->level*4)!!}{{$v->cate_name}}</td>

      <td>
       <div class="layui-btn-group">
          <button class="layui-btn layui-btn-sm del">
            <i class="layui-icon">&#xe640;</i>
          </button>
        </div> &nbsp;&nbsp;&nbsp;&nbsp;
        <button class="btn btn-danger"><a href="/cate/type?cate_id={{ $v->cate_id }}">类型添加</a></button>&nbsp;&nbsp;&nbsp;
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<script type="text/javascript">
    //删除
    $('.del').click(function(){
      var _this=$(this);
      if(confirm("是否确认删除")){
        var cate_id=_this.parents('tr').attr('cate_id');
        $.ajax({
          url:"/cate/del",
          data:{cate_id:cate_id},
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
     //只显示pid位0的顶级分类
    $('tr:gt(0)').each(function(){
      var _this=$(this);
      //判断是否为顶级分类   不是顶级分类不显示
      if (_this.attr('parent_id')!=0) {
          _this.hide();        
      }
    });
    $('.btn').click(function(){
      var _btn=$(this);
      //获取tp_id值
      var tp_id=_btn.parents('tr').attr('cate_id');
      //判断是加号还是减号  加号变减号  减号变加号
      if (_btn.text()=='+') {
        _btn.text('-');
        //自定义函数引用  隐藏变现实
        suwed(tp_id);
      }else{
          _btn.text('+');
          jqus(tp_id);
      }
    });
    //定义显示函数
    function suwed(tp_id){
      $('tr').each(function(){
      var _tr=$(this);
      if (_tr.attr('parent_id')==tp_id) {
        _tr.show();
      }
    });
    };
   function jqus(tp_id){
    //定义递归隐藏函数
    $('tr').each(function(){
      var _tr=$(this);
      if (_tr.attr('parent_id')==tp_id) {
          _tr.hide();
        //隐藏子类的子类  
        jqus(_tr.attr('cate_id'));
      }
    });

   };
 
  </script>
@endsection
