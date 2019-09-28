<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_role';

    protected $fillable = ['name'];
    
    public function people()
    {
        return $this->hasMany('App\Person', 'id_role', 'id_role');
    }
}
