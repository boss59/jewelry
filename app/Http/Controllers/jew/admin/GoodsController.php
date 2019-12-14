<?php

namespace App\Http\Controllers\jew\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
use App\Models\BrandModel;
use App\Models\CateModel;

class GoodsController extends Controller
{
    // 添加
    public function save()
    {
    	//获取分类数据
    	$data = CateModel::get()->toArray();
    	//递归循环
        $cate = createTree($data);
       	//获取品牌数据 
        $brand = BrandModel::get()->toArray();
        // dd($brand);
        return view('jew.admin.goods.save',['cate'=>$cate,'brand'=>$brand]);

    }

    // 商品 添加
    public function save_do(Request $request)
    {
    	//获取所有数据
       	$data = $request->except('_token');
       	// dd($data);
       	//判断唯一性
        $res = GoodsModel::where(['goods_name'=>$data['goods_name']])->first();
        if($res){
        	echo json_encode(['code'=>2,"msg"=>"商品名称已存在"]);die;
        }
        //判断是否为空
        if(empty($data['goods_name'])){
        	echo json_encode(['code'=>2,"msg"=>"商品名称不能为空"]);die;
        }
        if(empty($data['goods_article'])){
        	echo json_encode(['code'=>2,"msg"=>"商品号不能为空"]);die;
        }
        if(empty($data['cate_id'])){
        	echo json_encode(['code'=>2,"msg"=>"分类必选"]);die;
        }
        if(empty($data['brand_id'])){
        	echo json_encode(['code'=>2,"msg"=>"品牌必选"]);die;
        }
        if(empty($data['goods_price'])){
        	echo json_encode(['code'=>2,"msg"=>"商品价格不能为空"]);die;
        }
        if(empty($data['goods_num'])){
        	echo json_encode(['code'=>2,"msg"=>"商品库存不能为空"]);die;
        }
        if(empty($data['goods_desc'])){
        	echo json_encode(['code'=>2,"msg"=>"商品说明不能为空"]);die;
        }
        if(empty($data['goods_img'])){
        	echo json_encode(['code'=>2,"msg"=>"商品图片不能为空"]);die;
        }
        //处理图片
        $data['goods_img'] = create_img($data['goods_img'],'/goods/');
        //入库
        $req = GoodsModel::create($data);
        if($req){
        	echo json_encode(['code'=>1,"msg"=>"添加成功"]);
        }else{
        	echo json_encode(['code'=>2,"msg"=>"添加失败"]);
        }
    }

    // 商品 展示
    public function show(Request $request)
    {
    	$info=$request->session()->get('user_info');

    	$where = [];
   		$query = $request->input();

   		//分类搜索
        if (!empty($request->input('cate_id'))) {
            $where[]=['shop_goods.cate_id','=',$request->input('cate_id')];
        }
        //品牌搜索
        if (!empty($request->input('brand_id'))) {
            $where[]=['shop_goods.brand_id','=',$request->input('brand_id')];
        }
        //关键字 条件搜索
        if (!empty($request->input('goods_name'))){
            $where [] = ['shop_goods.goods_name','like',"%".$request->input('goods_name')."%"];
        }
        //热门  条件搜索
        $is_up = $request->input('is_up');
        if ($is_up == "0" || $is_up == "1") {
            $where[]=['shop_goods.is_up','=',$is_up];
        }
    	
    	//获取分类数据
    	$cate = CateModel::get()->toArray();
    	//循环
    	$cate = createTree($cate);
       	//获取品牌数据 
        $brand = BrandModel::get()->toArray();

        // 商品展示   三表联查
        $goods = GoodsModel::join('shop_category','shop_goods.cate_id','=',"shop_category.cate_id")
        		->join('shop_brand','shop_goods.brand_id','=',"shop_brand.brand_id")
        		->where($where)
        		->paginate(2);
        // dd($goods);
    	return view('jew.admin.goods.show',compact("info","query","goods","cate","brand"));
    }

    //商品删除
    public function del(Request $request)
    {
    	$arr = $request->post();
    	// dd($arr);
    	$res = GoodsModel::where(['goods_id'=>$arr['goods_id']])->delete();
    	// dd($res);
    	if($res){
    		echo json_encode(['code'=>1,"msg"=>"删除成功"]);
    	}else{
    		echo json_encode(['code'=>2,"msg"=>"删除失败"]);
    	}
    }
}
