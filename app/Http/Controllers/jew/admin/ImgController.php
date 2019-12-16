<?php

namespace App\Http\Controllers\jew\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
use App\Models\ImgModel;
class ImgController extends Controller
{
    // 多文件上传
    public  function  create(Request $request)
    {
        $info=$request->session()->get('user_info');
        // 查询上架商品
        $goods=GoodsModel::where(['is_up'=>1])->get()->toArray();

        if ($request->isMethod('POST')) {

        }
        return view('jew.admin.img.create',['goods'=>$goods,'info'=>$info]);
    }
    //多文件添加
    public function save(Request $request)
    {
        //接收所有数据
        $data = $request->except('_token');
//        dd($data);
        //验证
        if(empty($data['goods_id'])){
            echo json_encode(['code'=>2,'msg'=>"图片分类不能为空"]);die;
        }
        if(empty($data['img_url'])){
            echo json_encode(['code'=>2,'msg'=>"图片不能为空"]);die;
        }
        if(empty($data['img_desc'])){
            echo json_encode(['code'=>2,'msg'=>"说明不能为空"]);die;
        }
        //处理图片
        $data['img_url'] = create_img($data['img_url'],'/img/');
        //入库
        $req = ImgModel::create($data);
        if($req){
            echo json_encode(['code'=>1,"msg"=>"添加成功"]);
        }else{
            echo json_encode(['code'=>2,"msg"=>"添加失败"]);
        }

    }
    //多文件展示
    public function index(Request $request)
    {
        $info=$request->session()->get('user_info');
        //echo 111;die;
        $data = ImgModel::paginate(3);
        return view('jew.admin.img.index',['data'=>$data,'info'=>$info]);
    }
    //多文件删除
    public function del(Request $request)
    {
        $arr = $request->post();
        //dd($arr);
        $res = ImgModel::where(['id'=>$arr['id']])->delete();
        //dd($res);
        if($res){
            echo json_encode(['code'=>1,"msg"=>"删除成功"]);
        }else{
            echo json_encode(['code'=>2,"msg"=>"删除失败"]);
        }
    }
}
