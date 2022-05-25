<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select(['id','name', 'date', 'phone', 'email', 'address_id'])
            ->with('address.city.state')
            ->get();

        return response(UserResource::collection($users), 201);
    }

    public function store(UserRequest $request)
    {
        $request['password'] = Hash::make($request->password);

        if(!User::create($request->all())) {
            return response(['message' => 'error to save data.'], 500);
        }

        return response(['message' => 'Data saved successfully.'], 201);
    }

    public function show(int $id)
    {
        $users = User::select(['id','name', 'date', 'phone', 'email', 'address_id'])
            ->with('address.city.state')
            ->where('id', $id)
            ->get();

        return response(UserResource::collection($users), 201);
    }

    public function update(UserRequest $request, int $id)
    {
        $request['password'] = md5($request->password);

        if(!User::where('id', $id)->update($request->all())) {
            return response(['message' => 'Error to update data.'], 500);
        }

        return response(['message' => 'Data updated successfully.'], 201);
    }

    public function destroy(int $id)
    {
        $user = User::find($id);

        if(!$user) {
            return response(['message' => 'No data to delete.'], 203);
        }

        if(!$user::destroy($id)) {
            return response(['message' => 'Error to delete data.'], 500);
        }

        return response(['message' => 'Data removed successfully.'], 201);
    }

    public function getManyUserByState(int $state_id)
    {
        $users = User::query()
            ->whereHas('address.city.state', function($query) use($state_id) {
                $query->where('id', $state_id);
            })
            ->count(); 

        return response(['users' => $users], 201);
    }

    public function getManyUserByCity(int $city_id)
    {
        $users = User::query()
            ->whereHas('address.city', function($query) use($city_id) {
                $query->where('id', $city_id);
            })
            ->count();
        
        return response(['users' => $users], 201);
    }
}
