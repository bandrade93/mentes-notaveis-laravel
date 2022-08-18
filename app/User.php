<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['address_id', 'name', 'date', 'phone', 'email', 'password'];

    protected $appends = ['active_text', 'phone_formated'];

    public function getPhoneFormatedAttribute()
    {
        return preg_replace(
            '~.*(\d{2})[^\d]{0,7}(\d{5})[^\d]{0,7}(\d{4}).*~',
            '($1) $2-$3',
            $this->phone
        );
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function getActiveTextAttribute()
    {
        return ($this->active) ? 'Ativo' : 'Inativo';
    }

    public function address()
    {
        return $this->belongsTo('App\Address', 'address_id', 'id');
    }
}
