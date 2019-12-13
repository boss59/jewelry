<?php

namespace App\Http\Controllers\jew\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\BrandModel;
class BrandController extends Controller
{
    /**
     * 品牌添加页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand()
    {
        return view('jew.admin.brand.brand');
    }

    /**
     * 品牌添加
     * @param Request $request
     * @return string
     */
    public function brandadd(Request $request)
    {
        $data = $request->input();
//        var_Dump($data);die;
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            $data['brand_brand']=create_img($data['brand_brand'],'/brand/');// 上传 imgs
            //判断是否为空
            if(empty($data['brand_brand'])){
                return "<script>alert('不能为空');parent.location.href='/admin/brand';</script>";die;
            }
//            var_dump($data);exit;
            $brand  = BrandModel::where('brand_name',$data['brand_name'])->first();
            if(!empty($brand)){
                return "<script>alert('已存在');parent.location.href='/admin/brand';</script>";die;
            }
            $res = BrandModel::insert($data);
            if ($res){
                echo 1;die;
            }else{
                echo 2;die;
            }
        }
    }

    /**
     * 页面展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brandlist(Request $request){
        $inf = $request->input('brand_name');

        $where=[];
        if(!empty($request->input('brand_name'))){
            $where[] = ['shop_brand.brand_name','like','%'.$request->input('brand_name').'%'];
        }
        $list = BrandModel::where($where)->paginate(3);
        $page = $list->render();// 获取分页显示
        if (request()->ajax()) {
            $list = $list->toArray();//转化数组
            $list['page']=$page;//页码也返回到前台
            echo json_encode($list);die; //转化json数据
        }
        return view('jew.admin.brand.brandlist',['data'=>$list]);
    }

    /***
     * 删除
     * @param Request $request
     */
    public function branddel(Request $request){
            $id = $request->post('id');
            $arr =BrandModel::where('brand_id',$id)->delete();
            if($arr){
                echo 1;die;
            }else{
                echo 2;die;
            }
    }
}
