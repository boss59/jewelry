<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InfoModel;
class LoginController extends Controller
{
    // 前台注册
    public function regist(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            if (empty($data['uname'] && $data['upwd'] && $data['tel'] && $data['email'])) {
                echo json_encode(['code'=>0,"msg"=>"不可为空"]);die;
            }
            if (strlen($data['tel'])<11) {
                echo json_encode(['code'=>0,"msg"=>"请输入正确的手机号"]);die;
            }
            $info=InfoModel::where("uname",$data['uname'])->first();
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
            $data['upwd']=md5($data['upwd']);
            $data['add_time']=time();
            $res = InfoModel::create($data);
            if ($res){
                echo json_encode(['code'=>1,"msg"=>"注册成功",'user'=>$data]);die;
            }else{
                echo json_encode(['code'=>1,"msg"=>"注册失败"]);die;
            }
        }
    }
    // 前台登陆
    public function login(Request $request)
    {
        $refer = $request->input('refer');
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            // 用户验证
            $info = InfoModel::where('tel',$data['tel'])->first();
            if (empty($info)) {
                echo json_encode(['code'=>0,"msg"=>"账号不存在"]);die;
            }else{
                //判断密码是否正确
                if ($info['upwd']==md5($data['upwd'])) {//用库里加密密码 == 接收的加密密码
                    if (!empty($refer)) {
                        echo json_encode(['code'=>2,"urls"=>$refer,'user'=>$info]);die;
                    }else{
                        echo json_encode(['code'=>1,"msg"=>'登陆成功','user'=>$info]);die;
                    }
                }else{
                    echo json_encode(['code'=>0,"msg"=>"密码不正确"]);die;
                }
            }
        }

    }
}
