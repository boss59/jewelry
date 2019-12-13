<?php

namespace App\Http\Controllers\jew\index;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexContorller extends Controller
{
    // 前台 首页
    public function index()
    {
        return view('jew.index.index');
    }
    public function add(Request $request){
    	$post=$request->post();
    	$data=[
    		'name'=>$post['name'],
    		'pri'=>$post['pri'],
    		'num'=>$post['num']
    	];
    	$sq=DB::table('dodo')->insert($data);
    	$data=json_decode($data);
    	return $data;
    }
}
