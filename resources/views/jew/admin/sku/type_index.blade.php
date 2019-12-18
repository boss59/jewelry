@extends('layout.layout')

@section('title')
    类型 展示
@endsection
@section('content')
    <marquee><h2><font color='blue'>类型 展示</font></h2></marquee>

    <table class="layui-table" style="width: 1000px; margin-left:200px; margin-top: 50px;">
        <tr>
            <td align="center">标号</td>
            <td align="center">类型名</td>
            <td align="center">操作</td>
        </tr>
        <tbody id="list">
        @foreach($list as $k=>$v)
            <tr >
                <td align="center">{{ $v->type_id }}</td>
                <td align="center">{{ $v->type_name }}</td>
                <td align="center">
                    <button type="button" class="btn btn-danger del"><a href="/type/value_index?type_id={{ $v->type_id }}">查看属性值</a></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-warning" id="updata"><a href="/cate/type">类型添加</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-info" ><a href="/type/value">属性值添加</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-warning" id="updata"><a href="/goods/save">为商品添加类型 | 值</a></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div align="center" id="page">
        {{ $list->links() }}
    </div>
@endsection
