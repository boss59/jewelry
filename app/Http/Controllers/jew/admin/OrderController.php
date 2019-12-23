<?php

namespace App\Http\Controllers\jew\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderGoodsModel as order;
use App\Models\OrderInfoModel as orderinfo;
class OrderController extends Controller
{
    //展示页ss
   public function order(){
        $data=order::join('shop_info','shop_info.user_id','=','order_goods.user_id')->join('order_info','order_info.order_id','=','order_goods.order_id')->join('shop_goods','shop_goods.goods_id','=','order_goods.goods_id')->get()->toArray();
        return view('jew.admin.order.order',['data'=>$data]);
   }

}
