<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsModel;
class NewsController extends Controller
{
    // 新闻 列表
    public function news(Request $request)
    {
        $new_id=$request->input('new_id');
        if (empty($new_id)){
            $new=NewsModel::get()->toArray();
        }else{
            $new=NewsModel::where('new_id',$new_id)->get()->toArray();
        }

        $data = ['news'=>$new];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}
