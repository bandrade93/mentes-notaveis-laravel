<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['address_id','name', 'date', 'phone', 'email', 'password'];

    public function address ()
    {
        return $this->belongsTo('App\Address', 'address_id', 'id');
    }
}
