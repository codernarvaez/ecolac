<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'description'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'id_product', 'id_product');
    }
}
