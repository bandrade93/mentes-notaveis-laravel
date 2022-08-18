<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use SoftDeletes;

    protected $fillable = ['city_id','name', 'uf', 'active'];

    protected $appends = ['active_text'];

    public function getActiveTextAttribute()
    {
    	return ($this->active) ? 'Ativo' : 'Inativo';
    }
}
