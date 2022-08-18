<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = ['controller', 'action', 'title', 'icon', 'active'];

    protected $appends = ['active_text'];

    public function getActiveTextAttribute()
    {
    	return ($this->active) ? 'Ativo' : 'Inativo';
    }
}
