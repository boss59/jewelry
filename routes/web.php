<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::any('/admin/login','jew\admin\LoginContorller@login');// 后台登陆
Route::any('/admin/regist','jew\admin\LoginContorller@regist');// 后台注册


Route::group(['middleware'=>['AdminLogin']],function(){
    Route::any('/admin/index','jew\admin\AdminContorller@index');// 后台首页
});



