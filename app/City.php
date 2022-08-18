<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = ['state_id', 'name', 'active'];

    protected $appends = ['active_text'];

    public function getActiveTextAttribute()
    {
    	return ($this->active) ? 'Ativo' : 'Inativo';
    }

    public function state ()
    {
        return $this->belongsTo('App\State');
    }
}
