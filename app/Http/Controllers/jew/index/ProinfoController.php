<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
use App\Models\ImgModel;
use App\Models\AttrModel;
use App\Models\ValueModel;
class ProinfoController extends Controller
{
    // 商品详情
    public  function  proinfo(Request $request)
    {
        $goods_id=$request->input('goods_id');
        $goods=GoodsModel::where(['shop_goods.goods_id'=>$goods_id])->get()
            ->toArray();
        foreach($goods as $k=>$v){
                $goods[$k]['imgs_arr'] = ImgModel::where('goods_id',$goods_id)->get(['img_url','img_desc'])->toArray();
                $goods[$k]['attr'] = $this->attr($v['goods_id']);
        }
        $data = ['goods'=>$goods];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    //  sku 方法
    public function attr($goods_id)
    {
        $type = AttrModel::join('type','type.type_id','=','goods_attr.type_id')->distinct('type_id')->where('goods_id',$goods_id)->get(['type.type_id','type.type_name'])->toArray();
        foreach($type as $k=>$v){
            $type[$k]['son']=ValueModel::where('type_id',$v['type_id'])->get(['value_id','value_name'])->toArray();
        }
        return $type;
    }
}
