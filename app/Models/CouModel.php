<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouModel extends Model
{
    protected $table = 'shop_cou';// 表
//    protected $primaryKey = 'con_id';// 主键
    // 定义常量时间
    // const CREATED_AT = 'add_time';
    // const UPDATED_AT = 'update_time';
    //  int类型 时间
    //protected $dateFormat = 'U'; // U表示时间戳类型/
    // $guarded = [];// 不可批量赋值的属性。 不加字段 可以通过
    // protected $fillable = [];
    // // 可批量赋值的属性。 要加字段  可以通过
    // 取消自动维护
     public $timestamps = false;
}
