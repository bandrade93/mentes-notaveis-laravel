<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['address_id','name', 'date', 'phone', 'email', 'password'];

    public static function getUsers ()
    {
        $user = User::select('users.id','users.name', 'users.date', 'users.phone', 'users.email',
                'address.street', 'address.number','address.cep', 'states.uf',
                'states.name as stateName','cities.name as cityName')
                ->join('address','users.address_id','=','address.id')
                ->join('states','states.id','=','address.state_id')
                ->join('cities','cities.id','=','address.city_id')
                ->get();

        return $user;
    }

    public static function getUserbyId (int $id)
    {
        $user = User::select('users.id','users.name', 'users.date', 'users.phone', 'users.email',
                'states.uf', 'address.street', 'address.number','address.cep',
                'states.name as stateName','cities.name as cityName')
                ->join('address','users.address_id','=','address.id')
                ->join('states','states.id','=','address.state_id')
                ->join('cities','cities.id','=','address.city_id')
                ->where('users.id', $id)
                ->get();

        return $user;
    }

    public static function getUsersByState(int $state_id)
    {
        $user = User::select('users.id')
        ->join('address','users.address_id','=','address.id')
        ->join('cities','cities.id','=','address.city_id')
        ->join('states','states.id','=','cities.state_id')
        ->where('states.id', $state_id)
        ->count();

        return $user;
    }

    public static function getUsersByCity(int $city_id)
    {
        $user = User::select('users.id')
        ->join('address','users.address_id','=','address.id')
        ->join('cities','cities.id','=','address.city_id')
        ->join('states','states.id','=','cities.state_id')
        ->where('cities.id', $city_id)
        ->count();

        return $user;
    }
}
