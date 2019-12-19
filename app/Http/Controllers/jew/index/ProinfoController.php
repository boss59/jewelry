<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsModel;
use App\Models\ImgModel;
use App\Models\AttrModel;
class ProinfoController extends Controller
{
    // 商品详情
    public  function  proinfo()
    {
//        $goods=GoodsModel::Leftjoin('shop_img','shop_goods.goods_id','=','shop_img.goods_id')->get(['shop_goods.goods_id','shop_goods.goods_name','shop_goods.goods_price','shop_goods.goods_num','shop_goods.goods_img','shop_goods.goods_desc','shop_img.img_url','shop_img.img_desc','shop_goods.goods_article'])
//            ->toArray();
//        dd($goods);
        $s= AttrModel::join()->where('goods_id',9)->get()->toArray();
        dd($s);
        $goods=GoodsModel::get(['goods_id','goods_name','goods_price','goods_num','goods_desc'])->toArray();
        foreach($goods as $k=>$v){
                $goods[$k]['imgs_goods'] = ImgModel::where('goods_id',$v['goods_id'])->get()->toArray();
//                $goods[$k]['sku'] =
        }
        dd($goods);
    }
}
