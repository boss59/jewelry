<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
use App\Models\CateModel;
use App\Models\BrandModel;
class IndexController extends Controller
{
    // 前台首页
    public function index(Request $request)
    {
        $cid=$request->input('cate_id');
    }
}
