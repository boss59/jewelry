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

        if(empty($data)){
            $code=['code'=>400,'res'=>"创建失败"];
            $code = json_encode($code,JSON_UNESCAPED_UNICODE);
            return $code;
        }else{
            $data = ['add_time'=>time()];
            $res = AddressModel::insert($data);
            if($res) {
                if(!empty($data['ress'])){
                    return json_encode(['code'=>1,'ress'=>$data['ress']]);
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
