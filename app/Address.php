<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'id';
    protected $fillable = ['state_id','city_id', 'street', 'number', 'cep'];

    public function state ()
    {
        return $this->hasMany('App\State', 'id', 'state_id');
    }

    public function city ()
    {
        return $this->hasMany('App\City', 'id', 'city_id');
    }

}
