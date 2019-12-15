<?php

namespace App\Http\Controllers\jew\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
class ImgController extends Controller
{
    // 多文件上传
    public  function  create(Request $request)
    {
        // 查询上架商品
        $goods=GoodsModel::where(['is_up'=>1])->get()->toArray();

        if ($request->isMethod('POST')) {

        }
        return view('jew.admin.img.create',['goods'=>$goods]);
    }
}
