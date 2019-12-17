<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CateModel;
class CateController extends Controller
{
    // 分类
    public function cate()
    {

        // dd($nav);
        // 商品分类
        $catData = CateModel::get()->toArray();
        $list = createTreeBySon($catData);
        $data = ['list'=>$list];

        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}
