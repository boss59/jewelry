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
        $friend=FriendModel::get()->toArray();

        $goods=GoodsModel::where('is_up',1)->where('is_sell',1)->get()->toArray();
        dd($goods);
        $cid=$request->input('cate_id');
    }
}
