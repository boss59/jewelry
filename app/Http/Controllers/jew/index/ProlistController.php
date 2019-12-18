<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
class ProlistController extends Controller
{
    //列表展示
    public function goods_list(Request $request){
        $data = $request->input();
        $info  = GoodsModel::get()->toArray();
        $data = json_encode($info,JSON_UNESCAPED_UNICODE);
        return $data;
    }

    //根据库存查
    public function goodsnum(Request $request){
        $data = $request->input();
        if ($data['asc'] = 'desc'){
            $info  = GoodsModel::orderBy($data['goods_num'],'desc')->get()->toArray();
        }else{
            $info  = GoodsModel::orderBy($data['goods_num'],'asc')->get()->toArray();
        }
        $data = json_encode($info,JSON_UNESCAPED_UNICODE);
        return $data;
    }

    //根据价格查询
    public function goodsprice(Request $request){
        $data = $request->input();
        if ($data['asc'] == 'asc'){
            $info  = GoodsModel::orderBy($data['goods_price'],'asc')->get()->toArray();
        }else{
            $info  = GoodsModel::orderBy($data['goods_price'],'desc')->get()->toArray();
        }
        $data = json_encode($info,JSON_UNESCAPED_UNICODE);
        return $data;
    }

    //模糊查询
    public function valuelist(Request $request){
        $data = $request->input();
        $info  = GoodsModel::where('goods_name','like','%'.$data["goods_name"].'%')->get()->toArray();
        $data = json_encode($info,JSON_UNESCAPED_UNICODE);
        return $data;
    }
}
