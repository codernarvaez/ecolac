<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'code',
        'observations'
    ];

    protected $attributes = [
        'state' => 'pending'
    ];

    public function details()
    {
        return $this->hasMany('App\OrderDetail', 'id_order', 'id_order');
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
