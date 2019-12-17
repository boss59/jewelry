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

        $cate = CateModel::where('parent_id',0)->get()->toArray();
        foreach($cate as $k=>$v){
            $cate[$k]['son'] = CateModel::where('parent_id',$v['cate_id'])->get()->toArray();
        }
        $data = ['list'=>$list,'cate'=>$cate];

        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}
