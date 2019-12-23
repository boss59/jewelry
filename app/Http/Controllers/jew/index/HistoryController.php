<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistoryModel;
class HistoryController extends Controller
{
    public function getHistory(Request $request)
    {
        $user_id = $request->input('user_id');
        // dump($res);
        if($user_id){
            // 添加 数据库
            return $this->getDBHistory($user_id);
        }else{
            // cookie
            return json_encode(['code'=>0,'font'=>'未登录']);
        }
    }
    //存数据库
    public function getDBHistory($user_id)
    {

    }
}
