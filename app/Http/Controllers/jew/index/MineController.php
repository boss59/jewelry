<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CollectModel;
use App\Models\HistoryModel;
class MineController extends Controller
{
    // 统计
    public function count(Request $request)
    {
        $user_id = $request->input('user_id');
        $where = ['user_id'=>$user_id];
        // 收藏
        $collect=CollectModel::where($where)->count();
        // 浏览历史
        $collect=CollectModel::where($where)->count();
        // 全部订单
        // 已付款
        // 未付款
    }


}
