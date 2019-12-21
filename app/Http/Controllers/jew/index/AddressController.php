<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AddressModel;
class AddressController extends Controller
{
    //地址添加
    public function address(Request $request){
        $user_id = $request->input('user_id');
        $address_name = $request->input('address_name');
        $address = $request->input('address');
        $tel = $request->input('tel');
        $consignee = $request->input('consignee');
        $is_deff = $request->input('is_deff');
        $ress = $request->input('ress');
        if(empty($user_id)){
            $code=['code'=>400,'res'=>"请先登录"];
            return json_encode($code,JSON_UNESCAPED_UNICODE);
        }else{
            $res = AddressModel::insert([
                'user_id'=>$user_id,
                'address_name'=>$address_name,
                'address'=>$address,
                'tel'=>$tel,
                'consignee'=>$consignee,
                'is_deff'=>$is_deff,
                'add_time'=>time()
            ]);
            if($res) {
                if(!empty($ress)){
                    return json_encode(['code'=>1,'ress'=>$ress]);
                }else{
                    $code = ['code' => 200,'res' => "添加成功"];
                    return json_encode($code, JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }

    //地址展示
    public function index(Request $request)
    {
        $data=AddressModel::get()->toArray();
        $data=json_encode($data);
        return $data;
    }
}
