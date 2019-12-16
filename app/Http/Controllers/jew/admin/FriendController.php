<?php

namespace App\Http\Controllers\jew\admin;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FriendController extends Controller
{
    // 友链添加
   public function add(Request $request)
   {
        $info=$request->session()->get('user_info');
   	    return view("jew.admin.friend.add",['info'=>$info]);
   }
   //友链添加执行
   public function doadd(Request $request)
   {
        $post=$request->except('_token');
        // 判断为空
        if (empty($post['f_name'])) {
         echo json_encode(['code'=>2,'msg'=>"链接名称不能为空"]);die;
        }
        if (empty($post['f_url'])) {
         echo json_encode(['code'=>2,'msg'=>"链接地址不能为空"]);die;
        }
        if (empty($post['f_logo'])) {
         echo json_encode(['code'=>2,'msg'=>"图片为空"]);die;
        }
        //唯一性验证
        $res=DB::table("shop_friend")->where(['f_name'=>$post['f_name']])->first();
        if ($res) {
        echo json_encode(['code'=>2,'msg'=>"链接名称已经臣在"]);die;
        }
        //处理照片
        $post['f_logo'] = create_img($post['f_logo'],'/friend/');
        // dd($post);
        $post['create_time']=time();
        $data=DB::table('shop_friend')->insert($post);
        // dd($data);
        if ($data) {
             echo json_encode(['code'=>1,'msg'=>"添加成功"]);die;
        }else{
             echo json_encode(['code'=>2,'msg'=>"添加失败"]);die;
        }
   }
   //友链展示
   public function index(Request $request)
   {
        $info=$request->session()->get('user_info');

   	    $data=DB::table("shop_friend")->paginate(3);
   	    // dd($data);
    	return view('jew.admin.friend.index',['data'=>$data,'info'=>$info]);
   }
   //删除
   public function del(Request $request){
   		$post=$request->post();
   		// dd($post);
   		$res=DB::table('shop_friend')->where(['f_id'=>$post['f_id']])->delete();
   		if ($res) {
   		  echo json_encode(['code'=>1,'msg'=>"删除成功"]);die;
   		}else{
   		  echo json_encode(['code'=>2,'msg'=>"删除失败"]);die;
   		}
   }
}
