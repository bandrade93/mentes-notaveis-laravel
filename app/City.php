<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'id';
    protected $fillable = ['state_id','name'];

    public function state ()
    {
        return $this->hasMany('App\State', 'id', 'state_id');
    }
}
