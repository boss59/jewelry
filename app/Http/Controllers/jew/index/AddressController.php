<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AddressModel;
class AddressController extends Controller
{
    //地址添加
    public function address(Request $request){
        $data = $request->input();
//        var_dump($data);
//        $data= [
//                'user_id' =>1,
//                'address_name'=>'asdf',
//                'x_address'=>'asdfasdfasd',
//                'consignee'=>"刘醒",
//                'is_deff'=>1,
//                'tel'=>13651503379,
//                'time'=>time()
//                ];
        $code=[];
        if(empty($data)){
            $code=[
                'code'=>400,
                'res'=>"创建失败"
            ];
            $code = json_encode($code,JSON_UNESCAPED_UNICODE);
            return $code;
        }else{
            $res = AddressModel::insert($data);
            if($res) {
                $code = [
                    'code' => 200,
                    'res' => "创建成功"
                ];
                $code = json_encode($code, JSON_UNESCAPED_UNICODE);
//                var_dump($code);
                return $code;
            }
        }
//

            var_dump($res);die;
    }

    //地址展示
    public function index(Request $request)
    {
        $data=AddressModel::get()->toArray();
        $data=json_encode($data);
        return $data;
    }
}
