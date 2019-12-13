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
Route::any('/admin/login','jew\login\LoginContorller@login');// 后台登陆
Route::any('/admin/regist','jew\login\LoginContorller@regist');// 后台注册

//=================   后台 中间件  =================================
Route::group(['middleware'=>['AdminLogin']],function(){
    Route::any('/admin/index','rbac\AdminController@index');// 后台首页

    // 管理员 管理
    Route::any('/admin/admin_add','rbac\AdminController@admin_add');// 管理员添加
    Route::any('/admin/admin_index','rbac\AdminController@admin_index');// 管理员展示
    Route::any('/admin/admin_del','rbac\AdminController@admin_del');// 管理员删除
    Route::any('/admin/admin_update','rbac\AdminController@admin_update');// 管理员修改
    Route::any('/admin/reset','rbac\AdminController@reset');// 管理员重置密码

    // 角色 管理
    Route::any('/admin/role_add','rbac\AdminController@role_add');// 角色 添加
    Route::any('/admin/role_index','rbac\AdminController@role_index');// 角色 展示
    // 权限 管理
    Route::any('/admin/right_add','rbac\AdminController@right_add');// 权限 添加
    Route::any('/admin/right_index','rbac\AdminController@right_index');// 权限 展示
    // admin 角色 管理
    Route::any('/admin/admin_role_add','rbac\AdminController@admin_role_add');// admin 角色 添加
    Route::any('/admin/admin_role_index','rbac\AdminController@admin_role_index');// admin 角色 展示
    // 角色权限 管理
    Route::any('/admin/role_right_add','rbac\AdminController@role_right_add');// 角色权限 添加
    Route::any('/admin/role_right_index','rbac\AdminController@role_right_index');// 角色权限 展示

    // 分类管理

    // 品牌管理

    // 商品管理


});



