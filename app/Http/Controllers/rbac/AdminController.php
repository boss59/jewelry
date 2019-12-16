<?php

namespace App\Http\Controllers\rbac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\UserModel;
use  App\Models\RoleModel;
use  App\Models\RightModel;
use  App\Models\Role_RightModel;
use  App\Models\Admin_RoleModel;
class AdminController extends Controller
{
    // admin 首页
    public function index(Request $request)
    {
        $info=$request->session()->get('user_info');
        return view("jew.admin.index",["info"=>$info]);
    }
    // 管理员 添加
    public function admin_add(Request $request)
    {
        $info=$request->session()->get('userinfo');
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            if (empty($data['uname'] && $data['pwd'] && $data['tel'] && $data['email'])) {
                echo "不能为空";die;
            }
            if (strlen($data['tel'])<11) {
                echo "请输入正确的手机号";die;
            }
            $info=UserModel::where("uname",$data['uname'])->first();
            if (!empty($info)){
                echo "用户已存在";die;
            }
            $check = '/^(1(([35789][0-9])|(47)))\d{8}$/';
            if (!preg_match($check,$data['tel'])) {
                echo "请输入合法的手机号";die;
            }
            $check = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
            if(!preg_match($check,$data['email'])){
                echo "email不和法";die;
            }
            $data['pwd']=md5($data['pwd']);
            $data['add_time']=time();
            $res = userModel::create($data);
            if ($res){
                return redirect("admin/admin_index");
            }else{
                return redirect("admin/admin_add");
            }

        }
        return view("rbac.user.add",['info'=>$info]);
    }
    // 管理员 展示
    public function admin_index(Request $request)
    {
        $info=$request->session()->get('user_info');
        $index=UserModel::paginate(5);
        return view("rbac.user.index",['index'=>$index,'info'=>$info]);
    }
    // 管理员 删除
    public function admin_del(Request $request)
    {
        $user_id = $request->all();
        // dd($user_id);
        $where = [
            'user_id'=>$user_id
        ];
        $res = UserModel::where($where)->delete();
        if ($res) {
            return redirect("/admin/admin_index");
        }
        return redirect()->back();
    }
    //管理员 修改
    public function admin_update(Request $request)
    {
        $info=$request->session()->get('userinfo');
        $user_id = $request->all();
        $where = [
            'user_id'=>$user_id
        ];
        if($request->isMethod('POST')){
            $all = $request->except('_token');
            $res = UserModel::where($where)->update($all);
            if($res){
                return redirect("/admin/admin_index");
            }
            return redirect()->back();
        }
        $aa = UserModel::where($where)->first();
        return view("rbac.user.update",['data'=>$aa,'info'=>$info]);
    }
    // 重置密码
    public function reset(Request $request)
    {
        $all = $request->all();
        $pwd=md5($all['pwd']);
        UserModel::where('user_id',$all['user_id'])->update(['pwd'=>$pwd]);
        echo json_encode(['code'=>1,'msg'=>"重置成功"]);
    }

//=====================   RBAC =================================================
    // 角色 添加
    public function role_add(Request $request)
    {
        $info=$request->session()->get('user_info');
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            if (empty($data['rname'])) {
                echo "不能为空";
                return redirect()->back();
            }
            $data['add_time']=time();
            $res = RoleModel::create($data);
            if ($res){
                echo 1;die;
            }
        }
        return view("rbac.role.add",['info'=>$info]);
    }
    // 角色 展示
    public function role_index(Request $request)
    {
        $info=$request->session()->get('user_info');
        $index = RoleModel::paginate(5);
        return view("rbac.role.index",['info'=>$info,'index'=>$index]);
    }
    // 权限 添加
    public function right_add(Request $request)
    {
        $info=$request->session()->get('user_info');
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            if (empty($data['rig_name'])) {
               echo 2;die;
            }
            $data['add_time']=time();
            $res = RightModel::create($data);
            if ($res){
                echo 1;die;
            }
        }
        return view("rbac.right.add",['info'=>$info]);
    }
    // 权限 展示
    public function right_index(Request $request)
    {
        $info=$request->session()->get('user_info');
        $index = RightModel::paginate(2);
        return view("rbac.right.index",['info'=>$info,'index'=>$index]);
    }
    // admin 角色 添加
    public function admin_role_add(Request $request)
    {
        $role = RoleModel::get();
        $admin = UserModel::get();
        $info=$request->session()->get('user_info');
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            $res = Admin_RoleModel::create($data);
            if ($res){
                echo 1;die;
            }
        }
        return view("rbac.admin_role.add",['info'=>$info,'admin'=>$admin,'role'=>$role]);
    }
    // admin 角色 展示
    public function admin_role_index(Request $request)
    {
        $info=$request->session()->get('user_info');
        $index = UserModel::join('admin_role','shop_admin.user_id','=','admin_role.user_id')
            ->join('role','role.role_id','=','admin_role.role_id')
            ->paginate(5);
        return view("rbac.admin_role.index",['info'=>$info,'index'=>$index]);
    }

    //  角色权限 添加
    public function role_right_add(Request $request)
    {
        $role = RoleModel::get();
        $right = RightModel::get();
        $info=$request->session()->get('userinfo');
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
//            dd($data);
            $res = Role_RightModel::create($data);
            if ($res){
                echo 1;die;
            }
        }
        return view("rbac.role_right.add",['info'=>$info,'rights'=>$right,'role'=>$role]);
    }
    // 角色权限 展示
    public function role_right_index(Request $request)
    {
        $info=$request->session()->get('userinfo');
        $index = UserModel::join('admin_role','shop_admin.user_id','=','admin_role.user_id')
            ->join('role','role.role_id','=','admin_role.role_id')
            ->join('role_right','role.role_id','=','role_right.role_id')
            ->join('right','role_right.right_id','=','right.right_id')
            ->paginate(5);
        return view("rbac.role_right.index",['info'=>$info,'index'=>$index]);
    }








}
