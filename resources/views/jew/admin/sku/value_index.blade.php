@extends('layout.layout')

@section('title')
    类型值 展示
@endsection
@section('content')
    <marquee><h2><font color='blue'>类型值 展示</font></h2></marquee>

    <table class="layui-table" style="width: 1000px; margin-left:200px; margin-top: 50px;">
        <tr>
            <td align="center">标号</td>
            <td align="center">属性名</td>
        </tr>
        <tbody id="list">
        @foreach($list as $k=>$v)
            <tr >
                <td align="center">{{ $v->value_id }}</td>
                <td align="center">{{ $v->value_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div align="center" id="page">
        {{ $list->links() }}
    </div>
@endsection
