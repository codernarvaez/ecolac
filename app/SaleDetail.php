<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'quantity',
        'parcial',
        'id_sale',
        'id_product'
    ];

    protected $attributes = [
        'quantity' => 1
    ];

    public function sale()
    {
        return $this->belongsTo('App\Sale', 'id_sale', 'id_sale');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'id_product', 'id_product');
    }
}
