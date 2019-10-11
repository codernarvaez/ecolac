<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_person';

    protected $fillable = [
        'dni',
        'firstname',
        'lastname',
        'phone',
        'email'
    ];

    public function role()
    {
        return $this->belongsTo('App\Role', 'id_role', 'id_role');
    }
    
    public function location()
    {
        return $this->hasOne('App\Location', 'id_person', 'id_person');
    }

    public function account()
    {
        return $this->hasOne('App\Account', 'id_person', 'id_person');
    }
}
