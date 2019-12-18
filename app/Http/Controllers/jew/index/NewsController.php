<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsModel;
class NewsController extends Controller
{
    // 新闻 列表
    public function news()
    {
        $new=NewsModel::get()->toArray();
        $data = ['new'=>$new];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}
