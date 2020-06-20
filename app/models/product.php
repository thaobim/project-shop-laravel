<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'code',
        'name',
        'slug',
        'price',
        'featured',
        'state',
        'info',
        'describe',
        'img',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\models\Category', 'category_id', 'id');
    }
}
