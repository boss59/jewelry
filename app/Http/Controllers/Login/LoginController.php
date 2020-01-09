<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\UserModel;
class LoginController extends Controller
{
    public function regist(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            if (empty($data['uname'] && $data['pwd'] && $data['code'])) {
                echo json_encode(['code'=>0,"msg"=>"不可为空"]);die;
            }

            $data['pwd']=md5($data['pwd']);
            $data['add_time']=time();
            unset($data['code']);
            $res = UserModel::create($data);
            if ($res){
                echo json_encode(['code'=>1,"msg"=>"注册成功"]);die;
            }else{
                echo json_encode(['code'=>0,"msg"=>"注册失败"]);die;
            }
        }
        return view('login.regist');
    }
    // 后台登陆
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            $info = UserModel::where('uname',$data['uname'])->first();//查询
            $list=\Cache::get($data['uname']);
            // 数据库 操作
            $data=$this->user($data);
            return $data;

        }
        return view('login.login');
    }
    // 验证码
    public function yan(Request $request)
    {
        return  rand(1000,9999);
    }
    // 首页
    public function index(Request $request)
    {

        $user_id= request()->session()->get('user_info');
        $list=UserModel::where(['user_id'=>$user_id])->first();
        return view('login.index',['info'=>$list['uname']]);
    }


    public function user($data)
    {
        $info = UserModel::where('uname',$data['uname'])->first();
        if (time()-$info['error_time']<60) {
            $time=60-(time()-$info['error_time']);
            return json_encode(['font'=>'账号已锁定到'.date("Y-m-d H:i:s",$info['error_time']),'res'=>0]);
        }
        if ($info) {
            if ($info['pwd']==md5($data['pwd'])) {
                UserModel::where(['user_id'=>$info['user_id']])->update(['error_num'=>0,'error_time'=>0]);
                request()->session()->put('user_info',$info['user_id'],86400);
                \Cache::set($info['uname'],$info['pwd'],86400);
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
}
