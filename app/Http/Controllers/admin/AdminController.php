<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\UserModel;
use App\admin\RoleModel;
use App\admin\RightModel;
use App\admin\Admin_RoleModel;
use App\admin\Role_RightModel;
class AdminController extends Controller
{
    // 注册
    public function regist(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->except('_token');
            $data['add_time'] = time();
            $data['pwd'] = md5($data['pwd']);
            $res=UserModel::create($data);
            if ($res){
                return redirect('/rbac/login');
            }else{
                return redirect()->back();
            }

        }
        return view('admin.regist');
    }
    // 登陆
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            // 用户验证
            $info = UserModel::where('uname',$data['uname'])->first();
            if (empty($info)) {
                return "<script>alert('账号不存在');parent.location.href='/rbac/login';</script>";die;
            }else{
                //判断密码是否正确
                if ($info['pwd']==md5($data['pwd'])) {//用库里加密密码 == 接收的加密密码
                    $request->session()->put('info',$info);
                    return "<script>alert('登陆成功');parent.location.href='/rbac/index';</script>";
                }else{
                    return "<script>alert('密码不正确');parent.location.href='/rbac/login';</script>";die;
                }
            }
        }
        return view('admin.login');
    }
    //首页
    public function index(Request $request)
    {
        $data= $request->session()->get('info');
        return view('admin.index',['info'=>$data['uname']]);
    }
    // 角色 添加
    public function role_add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            if (empty($data['rname'])) {
                echo "不能为空";
                return redirect()->back();
            }
            $data['add_time']=time();
            $res = RoleModel::create($data);
            if ($res){
                return redirect('/rbac/role_index');
            }else{
                return redirect()->back();
            }
        }
        return view("admin.role.add");
    }
    // 角色 展示
    public function role_index(Request $request)
    {
        $index = RoleModel::paginate(5);
        return view("admin.role.index",['index'=>$index]);
    }
    // 权限 添加
    public function right_add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            $data['add_time']=time();
            $res = RightModel::create($data);
            if ($res){
                return redirect('/rbac/right_index');
            }else{
                return redirect()->back();
            }
        }
        return view("admin.right.add");
    }
    // 权限 展示
    public function right_index(Request $request)
    {
        $index = RightModel::paginate(3);
        return view("admin.right.index",['index'=>$index]);
    }

    // admin 角色 添加
    public function admin_role_add(Request $request)
    {
        $role = RoleModel::get();
        $admin = UserModel::get();

        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            $res = Admin_RoleModel::create($data);
            if ($res){
                return redirect('/rbac/admin_role_index');
            }else{
                return redirect()->back();
            }
        }
        return view("admin.admin_role.add",['admin'=>$admin,'role'=>$role]);
    }
    // admin 角色 展示
    public function admin_role_index(Request $request)
    {
        $index = UserModel::join('admin_role','shop_user.user_id','=','admin_role.user_id')
            ->join('role','role.role_id','=','admin_role.role_id')
            ->paginate(5);
        return view("admin.admin_role.index",['index'=>$index]);
    }

    //  角色权限 添加
    public function role_right_add(Request $request)
    {
        $role = RoleModel::get();
        $right = RightModel::get();
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
//            dd($data);
            $res = Role_RightModel::create($data);
            if ($res){
                return redirect('/rbac/role_right_index');
            }else{
                return redirect()->back();
            }
        }
        return view("admin.role_right.add",['rights'=>$right,'role'=>$role]);
    }
    // 角色权限 展示
    public function role_right_index(Request $request)
    {
        $index = UserModel::join('admin_role','shop_user.user_id','=','admin_role.user_id')
            ->join('role','role.role_id','=','admin_role.role_id')
            ->join('role_right','role.role_id','=','role_right.role_id')
            ->join('right','role_right.right_id','=','right.right_id')
            ->paginate(3);
        return view("admin.role_right.index",['index'=>$index]);
    }
}
