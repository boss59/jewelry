<?php

namespace App\Http\Controllers\jew\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginContorller extends Controller
{
    // 后台登陆
    public function login()
    {
        return view('jew.admin.login.login');
    }
}
