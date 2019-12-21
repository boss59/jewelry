<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AddressModel;
use App\Models\CaryModel;
class OrderInfoController extends Controller
{
    //下订单
    public function order_info(Request $request)
    {
        $user_id = $request->input('user_id');
        if(empty($user_id)){
            return json_encode(['code'=>0,'font'=>'还未登陆']);
        }else{
            // 判断 是否 有 收货地址
            $Addressinfo = AddressModel::where(['user_id'=>$user_id])->get();
            // dd($Addressinfo);
            if (!count($Addressinfo)) {
                // 添加 地址界面
                return json_encode(['code'=>1,'font'=>'还未填写收货地址！']);
            }
        }



        // 根据 商品id 获取 商品信息
        $goods_id = $request->input('goods_id');
        if(empty($goods_id)){
            return json_encode(['code'=>2,'font'=>'无商品！']);
        }else{
            //查询 商品
            $goods = CaryModel::where('user_id',$user_id)
                ->whereIn('shop_goods.goods_id',$gid)
                ->join('shop_goods','shop_cary.goods_id','=','shop_goods.goods_id')
                ->get()->toArray();

            // 收货地址
            $address=AddressModel::where(['user_id'=>$user_id,'is_deff'=>1])->get()->toArray();

            // 总价钱
            $info = CaryModel::where('user_id',$user_id)
                ->whereIn('goods_id',$gid)
                ->get(['add_price','buy_number'])->toArray();
            $total = number_format(0,2,'.','');
            foreach ($info as $k => $v) {
                $total+=$v['add_price']*$v['buy_number'];
            }
            $data = ['goods'=>$goods,'address'=>$address,'total'=>$total];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }



    public function  aa()
    {
        // 收货地址
//        $AddressModels = new AddressModels;
//        $area = new AreaModels;
//        $all = $AddressModels->where(['user_id'=>$user_id,'is_deff'=>1])->get()->toArray();
//        foreach($all as $k=>$v){
//            $city = $v['city'];
//            $arr=$area->where('id',$city)->first()->toArray();
//            $all[$k]['city']=$arr['name'];
//            $province = $v['province'];
//            $arr=$area->where('id',$province)->first()->toArray();
//            $all[$k]['province']=$arr['name'];
//            $district = $v['district'];
//            $arr=$area->where('id',$district)->first()->toArray();
//            $all[$k]['district']=$arr['name'];
//        }
    }
}
