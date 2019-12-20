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
Route::any('/login/quit','jew\login\LoginContorller@quit');// 后台注册
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


    //分类管理
    Route::any('/cate/add','jew\admin\CateController@add');// 分类添加
    Route::any('/cate/doadd','jew\admin\CateController@doadd');//处理分类添加
    Route::any('/cate/index','jew\admin\CateController@index');//分类列表
    Route::any('/cate/del','jew\admin\CateController@del');//分类删除

    // 品牌管理
    Route::any('/admin/brand','jew\admin\BrandController@brand');//品牌
    Route::any('/admin/brandadd','jew\admin\BrandController@brandadd');//品牌添加
    Route::any('/admin/branddel','jew\admin\BrandController@branddel');//品牌删除
    Route::any('/admin/brandlist','jew\admin\BrandController@brandlist');//品牌展示

    // 商品管理
    Route::any('/goods/save','jew\admin\GoodsController@save');//商品添加
    Route::any('/goods/save_do','jew\admin\GoodsController@save_do');//商品执行
    Route::any('/goods/show','jew\admin\GoodsController@show');//商品展示
    Route::any('/goods/del','jew\admin\GoodsController@del');//商品删除
    Route::any('/admin/del_all','jew\admin\GoodsController@del_all');//商品批删
    Route::any('/admin/judge','jew\admin\GoodsController@judge');//商品即点即改


    //友情链接管理
    Route::any('/friend/add','jew\admin\FriendController@add');// 友情链接添加
    Route::any('/friend/doadd','jew\admin\FriendController@doadd');// 友情链接添加处理
    Route::any('/friend/index','jew\admin\FriendController@index');// 友情链接列表
    Route::any('/friend/del','jew\admin\FriendController@del');// 友情链接删除

    // 多文件上传
    Route::any('/img/create','jew\admin\ImgController@create');// 多文件添加
    Route::any('/img/save','jew\admin\ImgController@save');// 多文件执行
    Route::any('/img/index','jew\admin\ImgController@index');// 多文件列表
    Route::any('/img/del','jew\admin\ImgController@del');// 多文件删除

    //sku
    Route::any('/cate/type','jew\admin\CateController@type');// 类型添加
    Route::any('/type/value','jew\admin\CateController@value');// 类型添加
    Route::any('/type/index','jew\admin\CateController@type_index');// 展示
    Route::any('/type/value_index','jew\admin\CateController@value_index');// 展示
    Route::any('/value/value','jew\admin\GoodsController@value_value');// 展示


});




    //=============================  商城 前台 =======================
    //登陆注册
    Route::any('/index/regist','jew\index\LoginController@regist');// 前台注册
    Route::any('/index/login','jew\index\LoginController@login');// 前台登陆

    //首页
    Route::any('/index/index','jew\index\IndexController@index');// 前台首页
    Route::any('/index/ajaxgetFloor','jew\index\IndexController@ajaxgetFloor');// 楼呈

    //新闻
    Route::any('/index/news','jew\index\NewsController@news');

    //分类
    Route::any('/index/cate','jew\index\CateController@cate');// 前台首页

    //商品类表
    Route::any('/index/goods_list','jew\index\ProlistController@goods_list');//列表
    Route::any('/index/goodsnum','jew\index\ProlistController@goodsnum');//根据库存查
    Route::any('/index/goodsprice','jew\index\ProlistController@goodsprice');//根据价格查询
    Route::any('/index/valuelist','jew\index\ProlistController@valuelist'); //模糊查询

    //商品详情
    Route::any('/index/proinfo','jew\index\ProinfoController@proinfo');//商品详情
    Route::any('/index/type_value','jew\index\ProinfoController@type_value');//商品详情

    // 用户收藏夹
    Route::any('/index/user_collect','jew\index\CollectController@collect');// 用户收藏夹
    Route::any('/index/list_collect','jew\index\CollectController@list_collect');// 用户收藏夹

    // 加入购物车
    Route::any('/index/add_car','jew\index\ProinfoController@addcar');// 添加
    Route::any('/index/cary_index','jew\index\ProinfoController@cary_index');// 展示
    Route::any('/index/cary_del','jew\index\ProinfoController@cary_del');// 删除


    // 用户 收货地址
    Route::any('/index/address','jew\index\AddressController@address');//地址
    Route::any('/index/address_index','jew\index\AddressController@index');//用户地址展示





