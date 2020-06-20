<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'order';

    public function productOrder()
    {
        return $this->hasMany('App\models\productOrder', 'order_id', 'id');
    }
}
