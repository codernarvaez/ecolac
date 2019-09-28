<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'name',
        'description',
        'price',
        'iva',
        'type',
        'size',
        'color'
    ];

    protected $attributes = [
        'expires' => false,
        'deleted' => false
    ];

    public function details()
    {
        return $this->hasMany('App\ProductDetail', 'id_product', 'id_product');
    }

    public function lots()
    {
        return $this->hasMany('App\Lot', 'id_product', 'id_product');
    }
}
