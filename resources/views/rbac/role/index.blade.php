@extends('layout.layout')

@section('title')
    角色 展示
@endsection


@section('content')
    <marquee><h2><font color='blue'>你终会站上巅峰，回首来的路，都值得！！！</font></h2></marquee>
    <center>
        <div >
            <button><a href="{{ url("/admin/role_add") }}">返回添加</a></button>
        </div>
    </center>
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>序号</th>
            <th>角色名</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($index as $k=>$v)
            <tr>
                <td>{{ $v->role_id }}</td>
                <td>{{ $v->rname }}</td>
                <td>{{ date("Y-m-d H:i:s",$v->add_time) }}</td>
                <td>
                    <button class="btn btn-danger">删除</button> ||
                    <button class="btn btn-success">修改</button>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tr align="center">
            <td colspan="6">{{ $index->links() }}</td>
        </tr>
    </table>
@endsection