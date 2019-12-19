<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CollectModel;
class CollectController extends Controller
{
    // 用户收藏
    public function collect(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $user_id = $request->input('user_id');

        var_dump($goods_id);
        var_dump($user_id);exit;
        if (!empty($user_id)) {
            // 数据库
            return $result=$this->addcoller($goods_id,$user_id);
        }else{
            return $result=['font'=>'请先登录','code'=>0];
        }
        echo json_encode($result);
    }

    // 加入数据库
    public function addcoller($goods_id,$user_id)
    {
        $where = [
            'goods_id'=>$goods_id,
            'user_id'=>$user_id,
            'is_del'=>1,
        ];
        $info = CollectModel::where($where)->first();
        // dd($info);
        if (!empty($info)) {
            return ['font'=>'已收藏','code'=>1];die;
        }else{
            $res = CollectModel::create($where);
            if ($res) {
                return ['font'=>'','code'=>2];die;
            }else{
                return ['font'=>'收藏失败','code'=>0];die;
            }
        }
    }
}
