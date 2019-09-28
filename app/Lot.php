<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    protected $primaryKey = 'id_lot';

    protected $fillable = [
        'elaboration',
        'expiry',
        'quantity'
    ];

    protected $attributes = [
        'state' => true
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'id_product', 'id_product');
    }
}
