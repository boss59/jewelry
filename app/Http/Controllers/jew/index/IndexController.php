<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
use App\Models\CateModel;
use App\Models\BrandModel;
use App\Models\FriendModel;
class IndexController extends Controller
{
    // 前台首页
    public function index(Request $request)
    {
        // 轮播图
        $friend=FriendModel::get()->toArray();
        // 精品商品
        $sell=GoodsModel::where('is_up',1)->where('is_sell',1)->get()->toArray();

        //分类 下的商品
        $top_name=CateModel::where('prend_id',0)->get()->toArray();
        $floor = $this->getFloot($top_name['cate_id']);

        dd($floor);

        $data = ['friend'=>$friend,'sell'=>$sell,'top'=>$top_name,'goods'=>$floor['goods']];
    }

    // 方法
    public function getFloot($cate_id)
    {
        //根据 大分类获取 商品
        // 先 获取 当前 大分类 下的 子分类
        $cate_data = CateModel::get();
        $cate_data = CateModel::createTree($cate_data,$cate_id);
        $cateids = array_column($cate_data,'cate_id');
        // dump($cateids);die;
        array_unshift($cateids,$cate_id);
        // dump($a);die;
        //获取 商品
        $goods = GoodsModel::whereIn('cate_id',$cateids)->get();
        // dd($goods);
        // 组合数组
        return ['goods'=>$goods];
    }
    // ajax 楼层 数据显示
    public function ajaxgetFloor(Request $request)
    {
        $cate_id = $request->input('cate_id');

        $num = $request->input('num');
        $num = $num +1;

        // 条件
        $where = [
            ['parent_id','=',0],
            ['cate_id','>',$cate_id]
        ];
        // 获取 顶级分类
        $top_name = CsCate::where($where)->first();
        // dd($top_name['cate_id']);
        if (empty($top_name)) {
            echo 2;exit;
        }else{
            //调用 方法
            $floor = $this->getFloot($top_name['cate_id']);
            // dd($floor);
            return view('index.more',['num'=>$num,'goods'=>$floor['goods'],'top'=>$top_name]);
        }
    }
}
