<?php

namespace App\Http\Controllers\jew\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CouponsModel;

class CouponsController extends Controller
{
    //优惠券
    public function index(Request $request)
    {
        $data=CouponsModel::get()->toArray();
        $data=json_encode($data);
        return $data;
    }
}
