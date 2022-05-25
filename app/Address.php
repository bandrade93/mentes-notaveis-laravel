<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'id';
    protected $fillable = ['city_id', 'street', 'number', 'cep'];

    public function city ()
    {
        return $this->belongsTo('App\City');
    }

}
