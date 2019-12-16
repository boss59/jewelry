<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // 前台注册
    public function regist(Request $request)
    {
        $all = $request->input();
        dd($all);
    }
    // 前台登陆
    public function login(Request $request)
    {
        $all = $request->input();
        dd($all);
    }
}
