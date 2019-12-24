<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CouponsModel;
use App\Models\CouModel;
use Illuminate\Support\Facades\DB;
class CouponsController extends Controller
{
    //优惠券
    public function index(Request $request)
    {
        $data=CouponsModel::get()->toArray();
        $data=json_encode($data);
        return $data;
    }
    // 领取
    public function ling(Request $request)
    {
        $data=$request->input();
        $where = [
            "user_id"=>$data['user_id'],
            "con_id"=>$data['con_id'],
        ];
        if (empty($data['user_id'])){
            return json_encode(['code'=>1,'font'=>'未登录']);
        }else{
            // 启动事务
//            DB::beginTransaction();
//            try {
                $cot = CouModel::where($where)->first();
                if (!$cot) {
                    $cou = CouModel::create($where);
                    return json_encode($cou);
                    if ($cou) {
                        CouponsModel::where($where)->dec('num')->update();
                        return json_encode(['ret'=>'1','msg'=>'领取成功']);
                    }
                }else{
                    $ass=CouModel::where($where)->get()->toArray();
                    if ($ass) {
                        return json_encode(['ret'=>'1','msg'=>'已经领取过，不能再领了哦！']);
                    }
                }
//                // 提交事务
//                DB::commit();
//            } catch (\Exception $e) {
//                // 回滚事务
//                DB::rollback();
//                // echo $e->getNessage();
//            }
        }
    }
}
