<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderGoodsModel;
use App\Models\OrderInfoModel;
use App\Models\AddressModel;
use App\Models\CaryModel;
use App\Models\GoodsModel;
class OrdersController extends Controller
{
    // 订单管理
    public function orders(Request $request)
    {
        // 全部
        $user_id=$request->input('user_id');
        $where = [
            'user_id'=>$user_id,
        ];
        $data = $this->all_orders($where,$user_id);
        return $data;
    }

    // 待付款
    public function  Nopay(Request $request)
    {

        // 待付款
        $user_id=$request->input('user_id');
        $where = [
            'user_id'=>$user_id,
            'pay_status'=>0
        ];
        $data = $this->all_orders($where,$user_id);
        return $data;
    }

    //方法
    public function all_orders($where,$user_id)
    {
        $count = "";
        $order_info=OrderInfoModel::where($where)->get()->toArray();
        $data=[];
        foreach ($order_info as $key => $value) {
            $data[$key]['order_id']=$value['order_id'];
            $data[$key]['pay_status']=$value['pay_status'];
            $data[$key]['order_sn']=$value['order_sn'];
            $data[$key]['order_amount']=$value['order_amount'];
            $info=OrderGoodsModel::where(["order_id"=>$data[$key]['order_id'],"user_id"=>$user_id])->get()->toArray();
            $goods_id=[];
            foreach($info as $k=>$v){
                $goods_id[]=$v['goods_id'];
            }
            $count = OrderGoodsModel::whereIn("goods_id",$goods_id)->where('user_id',$user_id)->count();
            $data[$key]['shop_info']=OrderGoodsModel::join('shop_goods','order_goods.goods_id','=','shop_goods.goods_id')
                ->whereIn("order_goods.goods_id",$goods_id)
                ->get(['shop_goods.goods_name',"shop_goods.goods_img","shop_goods.goods_price","shop_goods.goods_id","order_goods.buy_number"])
                ->toArray();
        }
        $data = ['orders'=>$data,'count'=>$count];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }


    // 待发货
    public function fahuo()
    {

    }
    // 待收货
    public function shouhuo()
    {

    }
}
