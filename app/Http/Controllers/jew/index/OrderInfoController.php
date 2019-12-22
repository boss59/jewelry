<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
use App\Models\OrderGoodsModel;
use App\Models\OrderInfoModel;
use App\Models\AddressModel;
use App\Models\CaryModel;
use App\Models\GoodsModel;
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
        $gid = explode(',',$goods_id);
        if(empty($goods_id)){
            return json_encode(['code'=>2,'font'=>'无商品！']);
        }else{
            //查询 商品
            $goods = CaryModel::where('user_id',$user_id)
                ->whereIn('shop_goods.goods_id',$gid)
                ->join('shop_goods','shop_cary.goods_id','=','shop_goods.goods_id')
                ->Leftjoin('type','shop_cary.type_id','=','type.type_id')
                ->Leftjoin('type_value','shop_cary.type_id','=','type_value.value_id')
                ->orderBy('shop_cary.add_time',"desc")
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
    //支付宝支付
    public function confirmOrder(Request $request)
    {
        $data = $request->input();
        // 启动事务
        DB::beginTransaction();
        try {
            // 货单号
            $data['order_sn'] = $this->createordersn();
            // 配送方式
            $shippin_data = ["1"=>'申通快递','2'=>'城际快递','3'=>'邮局平邮'];
            $data['shipping_name'] = $shippin_data[$data['shipping_id']];
            // 支付方式
            $pay_data = ['1'=>'支付宝','2'=>'微信','3'=>'货到付款',"4"=>'银行卡'];
            $data['pay_name'] = $pay_data[$data['pay_id']];
            $data['add_time'] = time();
            $data['confirm_time'] = time();
            $data['pay_time'] = time();
            $data['shipping_time'] = time();
            // 支付的钱
            $data['order_amount'] = $data['goods_amount'];
            // 通过 affress_id 获取 收货人 信息
            $address = AddressModel::where('address_id',$data['address_id'])->first()->toArray();
            $data['consignee'] = $address['consignee'];
            $data['mobile'] = $address['tel'];
            $data['city'] = $address['address_name'];
            $data['address'] = $address['address'];
            // dd($data);
            $order_id = OrderInfoModel::insertGetId($data);
            // dd($order_id);die;
            // 订单 商品信息表
            $goods_id = explode(',',$data['goods_id']);
            // dump($goods_id);die;
            foreach ($goods_id as $k=>$v) {
                $arr = [
                    "user_id"=>$data['user_id'],
                    'order_id'=>$order_id,
                    'goods_id'=>$v,
                    'add_price'=>GoodsModel::getPrice($v),
                    'buy_number'=>CaryModel::getbuyNumber($v,$data['user_id'])
                ];
                // var_dump($arr);exit;
                OrderGoodsModel::create($arr);
            }
            // 清空 购物车
            $data['goods_id']=explode(",",$data['goods_id']);
            CaryModel::whereIn('goods_id',$data['goods_id'])->where('user_id',$data['user_id'])->delete();
            $message = 0;
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $message =1;
            // 回滚事务
            Db::rollback();
        }
        if (!$message) {
            return json_encode(['code'=>1,'font'=>'','order_id'=>$order_id]);
        }else{
            return json_encode(['code'=>1,'font'=>'下单失败']);
        }
    }
    //  提交 订单
    public function alipay(Request $request)
    {
        $order_id = $request->input('order_id');
        if (!$order_id) {
            return;
        }
        $orderinfo = OrderInfoModel::where('order_id',$order_id)->first(['order_sn','order_amount']);
        // 获取所有配置
        $config = config('alipay');

        $order = [
            // 订单号
            'out_trade_no' => $orderinfo['order_sn'],
            // 金额
            'total_amount' => $orderinfo['order_amount'],
            // 标题
            'subject' => '斗神',
            // 商品描述
            'body' => '七阶斗者意志',
        ];

        $alipay = Pay::alipay($config)->wap($order);

        return $alipay;
    }
    // 同步通知
    public function returnpay(Request $request)
    {
        // $in=$request->input();
        // 验证支付消息的可靠性
        $config = config('alipay');
        try{
            $data = Pay::alipay($config)->verify();
        }catch(\Exception $e){
            exit("验证服务器消息失败，支付失败!");
        }

        // dd($data);
        // 调用查询接口，查询订单的状态

        $res = $this->query($data->out_trade_no);

        if($res->trade_status == "TRADE_SUCCESS"){
            // 修改表中的订单状态
            OrderInfoModel::where('order_sn',$data->out_trade_no)->update(['pay_status'=>2]);
            echo "本次交易victory(胜利)";
            return redirect('/weui/orders');
        }
        echo "本次交易失败，支付失败状态为:".$res->trade_status;
        return redirect('/weui/orders');

    }
    // 异步通知
    public function notifypay(Request $request)
    {

    }
    // 查询接口，查询订单的状态
    protected function query($orderid){

        //phpinfo();die;
        $config = config('alipay');
        //var_dump($config);die;
        $data = Pay::alipay($config)->find($orderid);

        return $data;
    }






    // 货单号
    public function createordersn()
    {
        return "DNF".date("YmdHis").rand(100,999).uniqid();
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
