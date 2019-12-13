@extends('layout.layout')

@section('title')
    管理员 展示
@endsection


@section('content')
    <marquee><h2><font color='blue'>你终会站上巅峰，回首来的路，都值得！！！</font></h2></marquee>
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th>序号</th>
                <th>管理员姓名</th>
                <th>手机号</th>
                <th>邮箱</th>
                <th>创建时间</th>
                <th>功能</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        @foreach($index as $k=>$v)
            <tr aid="{{ $v->user_id }}">
                <td>{{ $v->user_id }}</td>
                <td>{{ $v->uname }}</td>
                <td>{{substr($v->tel,0,3)."****".substr($v->tel,7,4)}}</td>
                <td>{{ $v->email }}</td>
                <td>{{ date("Y-m-d H:i:s",$v->add_time) }}</td>
                <td>
                    <input type="button" value="重置密码" class="aaareset" pwd='000000'>
                </td>
                <td>
                    <button class="btn btn-danger"><a href="/admin/admin_del?id={{ $v['user_id'] }}">删除</a></button> ||
                    <button class="btn btn-success"><a href="/admin/admin_update?id={{ $v['user_id'] }}">修改</a></button>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tr align="center">
            <td colspan="7">{{ $index->links() }}</td>
        </tr>
    </table>
    <script>
        $(function(){
            // -------------------重置密码----------------------------
            $(document).on('click','.aaareset',function(){
                var _this = $(this);
                var pwd = _this.attr('pwd');
                var id = _this.parent().parent().attr('aid');
                // alert(id);return;
                // alert(pwd);
                $.ajax({
                    url:'/admin/reset',//请求地址
                    type:'get',//请求的类型
                    dataType:'json',//返回的类型
                    data:{pwd:pwd,user_id:id},//要传输的数据
                    success:function(res){ //成功之后回调的方法
                        if(res.code == 1){
                            alert(res.msg);
                        }
                    }
                })
            })
        })
    </script>
@endsection
