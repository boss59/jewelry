<?php

namespace App\Http\Controllers\jew\Admin;
use DB; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    // 分类添加
    public function add(){
        $data=DB::table('shop_category')->get();
        // dd($data);
        $data=json_decode($data);
        // 递归
        $data=$this->createTrees($data);
        // dd($data);
        return view('jew.admin.cate.add',['data'=>$data]);
    }

    // 执行分类
    public function doadd(Request $request){
      $post=$request->input();
      if (empty($post['cate_name'])) {
          echo json_encode(['code'=>2,'msg'=>"不能为空"]);die;
      }
      // dd($post);
      //查询
      $res=DB::table('shop_category')->where(['cate_name'=>$post['cate_name']])->first();
      // dd($res);
      if ($res) {
        echo json_encode(['code'=>2,'msg'=>"分类名称已存在"]);die;
      }else{
         $data=[
        'cate_name'=>$post['cate_name'],
        'parent_id'=>$post['parent_id']
          ];
          //添加
          $req=DB::table('shop_category')->insert($data);
          // dd($req);
          if ($req) {
            echo json_encode(['code'=>1,'msg'=>"添加成功"]);
          }else{
            echo json_encode(['code'=>2,'msg'=>"添加失败"]);
          }
      }
  
    }

    // 分类展示
    public function index(){
      $data=DB::table('shop_category')->orderBy('cate_id','desc')->get()->toArray();
      $data=$this->createTrees($data);
      return view('jew.admin.cate.index',['data'=>$data]);
    }

    // 分类删除
    public function del(Request $request){
          $data=$request->post();
          // dd($data);
          $res=DB::table('shop_category')->where(['parent_id'=>$data['cate_id']])->count();
          // dd($res);
          if ($res) {
            echo json_encode(['code'=>2,'msg'=>"该分类下有子类请先删除子类"]);die;
          }
          $req=DB::table('shop_category')->where(['cate_id'=>$data['cate_id']])->delete();
          if ($req) {
             echo json_encode(['code'=>1,'msg'=>"删除成功"]);die;
          }else{
             echo json_encode(['code'=>2,'msg'=>"删除失败"]);die;
          }
    }
    // 递归创建 分类 树形结构 对象
    public function createTrees($data,$parent_id=0,$level=1)
    {
        //1 定义 一个容器（新数组);
        static  $new_arr = [];
        //2 遍历 数据一条条比对
        foreach ($data as $key => $value) {
            //3找 parent_id = 0 的id
            if ($value->parent_id == $parent_id) {
                //增加级别 字段
                $value->level = $level;
                //4 找到 之后放到新的数组里
                $new_arr[] = $value;
                //调用 程序自身递归找子集
               $this->createTrees($data,$value->cate_id,$level+1);
            }
        }
        return $new_arr;
    }
}
