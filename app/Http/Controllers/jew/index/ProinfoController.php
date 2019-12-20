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

    //============ 购物车展示================================
    // 购物车
    public function cary_index(Request $request)
    {
        $user_id=$request->input('user_id');
        if (empty($user_id)){
            return $result=['font'=>'请先登录','code'=>3];
        }else{
            return $result=$this->listCaryDB($user_id);
        }
        echo json_encode($result);

    }
    // 数据库 展示
    public function listCaryDB($user_id)
    {
        $where = [
            ["shop_cary.user_id",'=',$user_id],
        ];
        $Caryinfo = CaryModel::where($where)
            ->join('shop_goods','shop_cary.goods_id','=','shop_goods.goods_id')
            ->join('type','shop_cary.type_id','=','type.type_id')
            ->join('type_value','shop_cary.type_id','=','type_value.value_id')
            ->orderBy('shop_cary.add_time',"desc")
            ->get()->toArray();
        if (!empty($Caryinfo)) {
            return $Caryinfo;
        }else{
            return $result=['font'=>'无数据','code'=>0];
        }
    }

// =================    列表操作 删除     =====================================
    //    /修改数量 /
    public function changeNumber(Request $request)
    {
        $buy_number = $request->input('buy_number');
        $goods_id = $request->input('goods_id');
        $user_id = $request->input('user_id');
        if ($user_id) {
            $res=$this->changeNumberDB($goods_id,$buy_number,$user_id);
        }else{
            $res=['font'=>'请先登录','code'=>0];
        }
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }
    // 库修改数量
    public function changeNumberDB($goods_id,$buy_number,$user_id)
    {
        // 条件
        $where = [
            ['user_id','=',$user_id],
            ['goods_id','=',$goods_id],
            ['is_del','=',1],
        ];
        $res = CaryModel::where($where)->update(['buy_number'=>$buy_number]);
        if($res){
            return ['font'=>'修改成功',"code"=>1];
        }else{
            return ['font'=>'已是最大 或 是一件',"code"=>2];
        }
    }
// -------------------小计--------------------------------------------
    public function getsubtotal(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $user_id = $request->input('user_id');
        if ($user_id) {
            $total=$this->getsubtotalDB($goods_id,$user_id);
        }else{
//            $total=['font'=>'请先登录','code'=>0];
        }
        echo json_encode($total,JSON_UNESCAPED_UNICODE);
    }
    // 库 小计
    public function getsubtotalDB($goods_id,$user_id)
    {
        // 后去 此用户 对 当前商品的购买数量
        $where = [
            ['user_id','=',$user_id],
            ['goods_id','=',$goods_id],
            ['is_del','=',1],
        ];
        $buy_number = CaryModel::where($where)->value('buy_number');
        $goodswhere = [
            ['goods_id','=',$goods_id]
        ];
        $goods_price = GoodsModel::where($goodswhere)->value('goods_price');
        return $buy_number*$goods_price;
    }
//==================== 总价   =============
    // 总价
    public function Pricetotal(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $user_id = $request->input('user_id');
        if ($user_id) {
            $total=$this->totalDB($goods_id,$user_id);
        }else{
            $total=['font'=>'请先登录','code'=>0];
        }
        echo json_encode($total,JSON_UNESCAPED_UNICODE);
    }
    // 数据库
    public function totalDB($goods_id,$user_id)
    {
        $gid = explode(',',$goods_id);
        $info = CaryModel::where('user_id',$user_id)
            ->whereIn('cs_goods.goods_id',$gid)
            ->join('cs_goods','cs_cary.goods_id','=','cs_goods.goods_id')
            ->get();
        // dd($info);
        $count=number_format(0,2,'.','');
        foreach ($info as $k => $v) {
            $count+=$v['goods_price']*$v['buy_number'];
        }
        echo $count;
        // dump($goods_price);
    }


//=================== 单删===================================
    public function cary_del(Request $request)
    {
        $goods_id=$request->input('goods_id');
        $user_id=$request->input('user_id');
        $where = [
            'user_id'=>$user_id,
            'goods_id'=>$goods_id,
        ];
        $cart  = CaryModel::where($where)->delete();
        // dd($cart);
        if ($cart) {
            echo json_encode(['font'=>'删除成功','code'=>1]);
        }else{
            echo json_encode(['font'=>'删除失败','code'=>2]);
        }
    }
    //批删
    public function alldel(Request $request)
    {
        $goods_id=$request->input('goods_id');
        $user_id=$request->input('user_id');
        $where = ['user_id'=>$user_id];
        $status  = CaryModel::whereIn('goods_id',$goods_id)->where($where)->delete();
        // dd($status);
        if ($status) {
            echo json_encode(['font'=>'删除成功','code'=>1]);
        }else{
            echo json_encode(['font'=>'删除失败','code'=>2]);
        }
    }
}
