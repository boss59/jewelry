  @extends('layout.layout')

@section('title')
    首页
@endsection

@section('content') 


<form class="layui-form layui-form-pane" action="javascript:;" style="margin: 50px ;" id="form" enctype="multipart/form-data">
     @csrf
  <div class="layui-form-item" style="padding-left:300px">
    <label class="layui-form-label">链接名称</label>
    <div class="layui-input-inline">
      <input type="text" name="f_name" required  id="name" lay-verify="required" placeholder="请输入链接名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  
 <div class="layui-form-item" style="padding-left:300px">
    <label class="layui-form-label">链接地址</label>
    <div class="layui-input-inline">
      <input type="url" name="f_url" required  id="url" lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="form-group" style="padding-left:300px">
      <label class="layui-form-label ">logo</label>
       <input type="file" class="form-control" placeholder="" name="f_logo" style="display: none" id="upload">
        <button class="btn btn-warning" id="img" type="button" >上传图片</button>
       <div for="inputPassword3" class="col-sm-2 control-label">
         <img src="{{ asset('/bootstrap/img/222.jpg') }}" alt="图片" class="img-thumbnail" width="200" height="200">
            </div>
        </div>

    <div class="layui-form-item layui-form-text" style="padding-left:300px">
        <label class="layui-form-label">介绍</label>
        <div class="layui-input-block">
            <textarea id="container" name="f_desc"  class="layui-textarea"></textarea>
        </div>
    </div>
    <div class="layui-form-item" style="padding-left:300px">
    <div class="layui-input-block">
     <input type="button" value="立即提交" class="layui-btn"  lay-filter="formDemo" id="btn" name="btn">
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

  // $(document).on('click',"#btn",function(){
  
       $("input[name='btn']").click(function(){
               var form = new FormData($("#form")[0]);
                // var form = $('#form').serialize();// 序列化serialize
                // alert(form);
                $.ajax({
                    url:"/friend/doadd",
                    data:form,
                    type:"POST",
                    dataType:'json',
                    processData: false, //需设置为false。因为data值是FormData对象，不需要对数据做处理
                    contentType: false, //需设置为false。因为是FormData对象，且已经声明了属性
                    success:function(res){
                      // alert(111);return;
                        if (res.code == 1) {
                            alert(res.msg);
                            location.href="/friend/index";
                        }else{
                            alert(res.msg);
                        }
                    }
                })
            })
      
  // });
</script>
      @endsection