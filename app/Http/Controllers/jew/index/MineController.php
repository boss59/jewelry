<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CollectModel;
use App\Models\HistoryModel;
use App\Models\GoodsModel;
use App\Models\OrderInfoModel;
class MineController extends Controller
{
    // 统计
    public function count(Request $request)
    {
        $user_id = $request->input('user_id');
        $where = ['user_id'=>$user_id];
        // 收藏
            $collect ="";
            $collect=CollectModel::where($where)->count();
        // 浏览历史
            $history ="";
            $data = HistoryModel::where($where)->get()->toArray();
            $goods_id = [];
            foreach($data as $k=>$v){
                $goods_id[] = $v['goods_id'];
            }
            $history=GoodsModel::whereIn('goods_id',array_unique($goods_id))->count();
        // 全部订单
            $order ="";
            $order = OrderInfoModel::where($where)->count();
        // 已付款
            $pay ="";
            $pay = OrderInfoModel::where($where)->where('pay_status',2)->count();
        // 未付款
            $Nopay ="";
            $Nopay = OrderInfoModel::where($where)->where('pay_status',0)->count();
        $res = ['collect'=>$collect,'history'=>$history,'order'=>$order,'pay'=>$pay,'Nopay'=>$Nopay];
        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }


}
