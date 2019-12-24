<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistoryModel;
use App\Models\GoodsModel;
class HistoryController extends Controller
{
    public function getHistory(Request $request)
    {
        $data = $request->input();
        // dump($res);
        if($data['user_id']){
            // 添加 数据库
            return $this->getDBHistory($data);
        }else{
            // cookie
            return json_encode(['code'=>0,'font'=>'未登录']);
        }
    }
    //存数据库
    public function getDBHistory($data)
    {
        $data['create_time'] = time();
        $res=HistoryModel::create($data);
        if($res){
            return json_encode(['code'=>1,'font'=>'添加成功']);
        }else{
            return json_encode(['code'=>0,'font'=>'添加失败']);
        }
    }
    //展示
    public function Historylist(Request $request)
    {
        $user_id = $request->input('user_id');
        if(empty($user_id)){
            return json_encode(['code'=>0,'font'=>'未登录']);
        }else{
            $data = HistoryModel::where('user_id',$user_id)->get()->toArray();
            $goods_id = [];
            foreach($data as $k=>$v){
                $goods_id[] = $v['goods_id'];
            }
            $goods=GoodsModel::whereIn('goods_id',array_unique($goods_id))->get()->toArray();
            return json_encode($goods,JSON_UNESCAPED_UNICODE);
        }

    }
}
