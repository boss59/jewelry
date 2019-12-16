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

        dd($friend);
        $cid=$request->input('cate_id');
    }
}
