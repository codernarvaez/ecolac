<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $primaryKey = 'id_sale';

    protected $fillable = [
        'code',
        'total',
        'payment_method'
    ];

    protected $attributes = [
        'paid' => false
    ];

    public function details()
    {
        return $this->hasMany('App\SaleDetail', 'id_sale', 'id_sale');
    }

    public function seller()
    {
        return $this->belongsTo('App\Person', 'id_person');
    }

    public function client()
    {
        return $this->belongsTo('App\Person', 'customer');
    }
}
