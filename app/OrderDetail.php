<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'quantity',
        'id_order',
        'id_product'
    ];

    protected $attributes = [
        'quantity' => 1
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'id_order', 'id_order');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'id_product', 'id_product');
    }
}
