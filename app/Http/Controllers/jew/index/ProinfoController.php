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
    public  function  proinfo()
    {
        $goods=GoodsModel::Leftjoin('shop_img','shop_goods.goods_id','=','shop_img.goods_id')->get(['shop_goods.goods_id','shop_goods.goods_name','shop_goods.goods_price','shop_goods.goods_num','shop_goods.goods_img','shop_goods.goods_desc','shop_img.img_url','shop_img.img_desc','shop_goods.goods_article'])
            ->toArray();
        foreach($goods as $k=>$v){
                $goods[$k]['imgs_arr'] = ImgModel::where('goods_id',$v['goods_id'])->get()->toArray();
                $goods[$k]['attr'] = $this->attr($v['goods_id']);
        }
        dd($goods);
    }

    //  sku 方法
    public function attr($goods_id)
    {
        $type = AttrModel::join('type','type.type_id','=','goods_attr.type_id')->where('goods_id',$goods_id)->get()->toArray();

        $type_id=array_column($type,'type_id');
        $type_id = array_unique($type_id);
        foreach($type_id as $k=>$v){
            $type_id[$k]=ValueModel::where('type_id',$type_id)->get(['value_id','value_name'])->toArray();
        }



//        $attr= AttrModel::join('type_value','goods_attr.value_id','=','type_value.value_id')
//            ->join('type','type.type_id','=','goods_attr.type_id')
//
//            ->where('goods_id',9)->get()->toArray();
        return $type_id;
    }
}
