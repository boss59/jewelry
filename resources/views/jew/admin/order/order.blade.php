@extends('layout.layout')

@section('title')
    订单 展示
@endsection

@section('content')
    <table class="layui-table" style="padding-left:300px">
        <tr>
            <td>id</td>
            <td>订单号</td>
            <td>收货人</td>
            <td>收货地址</td>
            <td>投递方式</td>
            <td>是否支付</td>
            <td>商品名称</td>
            <td>商品图片</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
        <tr>
            <td>{{$v['order_id']}}</td>
            <td>{{$v['order_sn']}}</td>
            <td>{{$v['uname']}}</td>
            <td>{{$v['address_name']}}</td>
            <td>{{$v['shipping_name']}}</td>
            <td>
                @if($v['pay_status']== 2)
                      已支付
                @elseif($v['pay_status']== 0)
                       未支付
                @endif
            </td>
            <td>{{$v['goods_name']}}</td>
            <td><img src="{{$v['goods_img']}}" width="70" height="50"></td>
            <td>删除|修改</td>
        </tr>
        @endforeach
    </table>
@endsection