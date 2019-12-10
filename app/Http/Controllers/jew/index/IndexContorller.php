<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexContorller extends Controller
{
    // 前台 首页
    public function index()
    {
        return view('jew.index.index');
    }
}
