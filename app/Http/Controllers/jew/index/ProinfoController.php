<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
use App\Models\ImgModel;
use App\Models\AttrModel;
use App\Models\ValueModel;
use App\Models\CaryModel;
class ProinfoController extends Controller
{
    // 商品详情
    public  function  proinfo(Request $request)
    {
        $goods_id=$request->input('goods_id');
        $goods=GoodsModel::where(['shop_goods.goods_id'=>$goods_id])->get()
            ->toArray();
        foreach($goods as $k=>$v){
                $goods[$k]['imgs_arr'] = ImgModel::where('goods_id',$goods_id)->get(['img_url','img_desc'])->toArray();
                $goods[$k]['attr'] = $this->attr($v['goods_id']);
        }
        $data = ['goods'=>$goods];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    //  sku 方法
    public function attr($goods_id)
    {
        $type = AttrModel::join('type','type.type_id','=','goods_attr.type_id')->distinct('type_id')->where('goods_id',$goods_id)->get(['type.type_id','type.type_name'])->toArray();
        foreach($type as $k=>$v){
            $type[$k]['son']=ValueModel::where('type_id',$v['type_id'])->get(['value_id','value_name'])->toArray();
        }
        return $type;
    }

    // sku 属性值
    public function type_value(Request $request)
    {
        $type_id = $request->input('type_id');
        $type = ValueModel::where('type_id',$type_id)->get()->toArray();
        $data = ['type'=>$type];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }



    // =========================    加入购物车     ====================
    //加入购物车
    public function addcar(Request $request)
    {
        $data = $request->input();
        if (empty($data['user_id'])){
            return $result=['font'=>'请先登录','code'=>3];
        }else{
            return $result=$this->addCaryDB($data);
        }
        echo json_encode($result);
    }
    //存数据库
    public function addCaryDB($data)
    {
        $where = [
            'user_id'=>$data['user_id'],
            'goods_id'=>$data['goods_id'],
        ];
        $info = CaryModel::where($where)->first();
        dd($info);
        if (!empty($info)) {
            // 验证库存
            $result=$this->checkBuynumber($data['goods_id'],$data['buy_number'],$info['buy_number']);
            if (is_array($result)) {
                return $result;
            }


            // 更新时间 更新购买数量
            $info['buy_number'] += $data['buy_number'];
            $info['add_time'] = time();
            $res=CaryModel::where($where)->update(['buy_number'=>$info['buy_number'],'add_time'=>$info['add_time']]);
            if ($res) {
                return ['font'=>'加入购物车成功','code'=>1];
            }else{
                return ['font'=>'加入购物车失败','code'=>2];
            }
        }else{
            // 验证 库存
            $result=$this->checkBuynumber($data['goods_id'],$data['buy_number']);
            if (is_array($result)) {
                return $result;
            }
            $data['add_time'] = time();
            // 新增
            // dd($data);
            $res=CaryModel::create($data);
            if ($res) {
                return ['font'=>'加入购物车成功','code'=>1];
            }else{
                return ['font'=>'加入购物车失败','code'=>2];
            }
        }
    }


    // 判断库存
    public function checkBuynumber($goods_id,$buy_number,$aleray_number=0)
    {
        // echo $aleaay_number;die;
        // 根据 商品 id 查询 商品表 得到 库存
        $goods_number=GoodsModel::where('goods_id',$goods_id)->value('goods_num');
        if (($buy_number + $aleray_number) > $goods_number) {
            return ['font'=>'库存不足,最多只能买'.($goods_number-$aleray_number).'件','code'=>2,'goods_number'=>$goods_number];
        }else{
            return true;
        }
    }





    //============ 购物车展示==============
    public function cary_index(Request $request){
        $u_id = $request->input('user_id');
        if(empty($u_id)){
            $code=[
                'code'=>0,
                'rsg'=>'请先登录'
            ];
            return $code;
        }else{
            $data = CaryModel::join('shop_goods','shop_goods.goods_id','=','shop_cary.goods_id')->where('user_id',$u_id)->get()->toArray();
            $res = json_encode($data,JSON_UNESCAPED_UNICODE);
            return $res;
        }


    }

    //购物车删除
    public function cary_del(Request $request){
        $goods_id = $request->input('goods_id');
        $user_id = $request->input('user_id');
        $data = CaryModel::where(['goods_id'=>$goods_id,'user_id'=>$user_id])->delete();
        if(empty($data)){
            $code=[
                'code'=>2,
                'res'=>"删除失败"
            ];
            return $code;
        }else{
            $code=[
                'code'=>1,
                'res'=>"删除成功"
            ];
            return $code;
        }
    }

    public function goodsbatch(Request $request){
        $user_id = $request->input('user_id');
    }
}
