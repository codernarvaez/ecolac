<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'code',
        'observations',
        'type',
        'state'
    ];

    protected $attributes = [
        'state' => 'pending'
    ];

    public function details()
    {
        return $this->hasMany('App\OrderDetail', 'id_order', 'id_order');
    }
}
