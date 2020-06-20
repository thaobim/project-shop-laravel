<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class productOrder extends Model
{
    protected $table = 'product_order';
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\models\order', 'order_id', 'id');
    }

}
