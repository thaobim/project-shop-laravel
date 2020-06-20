<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class info extends Model
{
    protected $table = 'info';
    //khai báo bảng ko có trường thời gian
    public $timestamps=false;

    //liên kết 1-1 ngược tới User
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
