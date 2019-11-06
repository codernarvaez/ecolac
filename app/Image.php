<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $primaryKey = 'id_image';

    protected $fillable = [
        'path',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'id_product', 'id_product');
    }
}
