<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    protected $table = 'user_address';// 表
    protected $primaryKey = 'address_id';// 主键
    public $timestamps = false;
}
