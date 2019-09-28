<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_location';

    protected $fillable = [
        'city',
        'address',
        'latitude',
        'longitude'
    ];

    public function person()
    {
        return $this->belongsTo('App\Person', 'id_person', 'id_person');
    }
}
