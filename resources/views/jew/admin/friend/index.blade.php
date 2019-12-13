  @extends('layout.layout')

@section('title')
    首页
@endsection

@section('content') 


<table class="layui-table">

  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>链接名称</th>
      <th>链接地址</th>
      <th>链接logo</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
@foreach ($data as $v)
    <tr f_id="{{$v->f_id}}">
      <td>{{$v->f_name}}</td>
      <td>{{$v->f_url}}</td>
      <td><img src="{{$v->f_logo}}"></td>
      <td>{{date('Y-m-d H:i:s',$v->create_time)}}</td>
      <td>
        <div class="layui-btn-group">
          <button class="layui-btn layui-btn-sm del">
          <i class="layui-icon">&#xe640;</i>
          </button>
        </div> 
      </td>
    </tr>
    @endforeach
    <tr align="center">
        <td colspan="14" > {{ $data->links() }}</td>
      </tr>
  </tbody>
</table>
<script type="text/javascript">
    $('.del').click(function(){
      var _this=$(this);
      if(confirm("是否确认删除")){
        var f_id=_this.parents('tr').attr('f_id');
        $.ajax({
          url:"/friend/del",
          data:{f_id:f_id},
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
      