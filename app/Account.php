<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Account extends Model implements AuthenticatableContract
{
    use Authenticatable;
    
    protected $primaryKey = 'id_account';

    protected $fillable = [
        'username'
    ];   

    protected $attributes = [
        'enabled' => true
    ];

    public function person()
    {
        return $this->belongsTo('App\Person', 'id_person', 'id_person');
    }
}
