<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'id';
    protected $fillable = ['city_id', 'street', 'number', 'cep'];

    public function setCepAttribute($value)
    {
        $this->attributes['cep'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function city ()
    {
        return $this->belongsTo('App\City');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
