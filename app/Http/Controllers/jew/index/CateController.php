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
        // 菜单
        $nav = CateModel::where('parent_id',0)->get()->toArray();
        // dd($nav);
        // 商品分类
        $catData = CateModel::get()->toArray();
        $list = createTreeBySon($catData);
        dd($list);
        $data = ['nav'=>$nav,'list'=>$list];
    }
}
