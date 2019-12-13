<?php

namespace App\Http\Controllers\jew\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminContorller extends Controller
{
    // 后台 首页
    public function index(Request $request)
    {
        $info=$request->session()->get('user_info');
        return view('jew.admin.index',['info'=>$info]);
    }
}
