<?php

namespace App\Http\Controllers\jew\login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
class LoginContorller extends Controller
{
    public function regist(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            if (empty($data['uname'] && $data['pwd'] && $data['tel'] && $data['email'])) {
                echo json_encode(['code'=>0,"msg"=>"不可为空"]);die;
            }
            if (strlen($data['tel'])<11) {
                echo json_encode(['code'=>0,"msg"=>"请输入正确的手机号"]);die;
            }
            $info=UserModel::where("uname",$data['uname'])->first();
            if (!empty($info)){
                echo json_encode(['code'=>0,"msg"=>"用户已存在"]);die;
            }
            $check = '/^(1(([35789][0-9])|(47)))\d{8}$/';
            if (!preg_match($check,$data['tel'])) {
                echo json_encode(['code'=>0,"msg"=>"请输入合法的手机号"]);die;
            }
            $check = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
            if(!preg_match($check,$data['email'])){
                echo json_encode(['code'=>0,"msg"=>"email不和法"]);die;
            }
//            endMail($data['email']);
            $data['pwd']=md5($data['pwd']);
            $data['add_time']=time();
            $res = UserModel::create($data);
            if ($res){
                $request->session()->put('user_info',$data,86400);
                echo json_encode(['code'=>1,"msg"=>"注册成功"]);die;
            }else{
                echo json_encode(['code'=>1,"msg"=>"注册失败"]);die;
            }
        }
    }
    // 后台登陆
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            // 用户验证
            $info = UserModel::where('uname',$data['uname'])->first();
            if (time()-$info['error_time']<60) {
                $time=60-(time()-$info['error_time']);
                return json_encode(['font'=>'账号已锁定到'.date("Y-m-d H:i:s",$info['error_time']),'res'=>0]);
            }
            if ($info) {
                if ($info['pwd']==md5($data['pwd'])) {
                    UserModel::where(['user_id'=>$info['user_id']])->update(['error_num'=>0,'error_time'=>0]);
                    $request->session()->put('user_info', $info);
                    return json_encode(['font'=>'登陆成功','res'=>1]);
                }else{
                    $error_num=$info['error_num'];
                    if ($error_num>=2) {
                        UserModel::where(['user_id'=>$info['user_id']])->update(['error_num'=>0,'error_time'=>time()]);
                        return json_encode(['font'=>'密码错误,3次将锁定账号','res'=>0]);
                    }else{
                        $error=$error_num+1;
                        $num=3-$error;
                        UserModel::where(['user_id'=>$info['user_id']])->update(['error_num'=>$error]);
                        return json_encode(['font'=>'密码错误,还有'.$num.'次机会','res'=>0]);
                    }
                }
            }else{
                return json_encode(['font'=>'账号未注册','res'=>0]);
            }

        }
        return view('jew.admin.login.login');
    }
    // 退出登陆
    public function quit(Request $request)
    {
        $request->session()->forget('userinfo');
        return redirect("admin/login");
    }
}
