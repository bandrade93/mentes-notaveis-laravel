<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getUsers();

        return response()->json($users, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if($request->validated()) {
            if(User::create($request->all())) {
                return response()->json(['message' => 'Data saved successfully.'], 201);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::getUserbyId($id);

        return response()->json($user, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, int $id)
    {
        if($request->validated()) {
            if(!User::where('id', $id)->update($request->all())) {
                return response()->json(['message' => 'Data does not exist.'], 201);
            }

            return response()->json(['message' => 'Data updated successfully.'], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::find($id);
        if(empty($user)) {
            return response()->json(['message' => 'No data to delete.'], 204);
        }

        if($user::destroy($id)) {
            return response()->json(['message' => 'Data removed successfully.'], 201);
        }
    }

    public function getManyUserByState(int $state_id)
    {
        $users = User::getUsersByState($state_id);
        return response()->json(['users' => $users], 201);
    }

    public function getManyUserByCity(int $city_id)
    {
        $users = User::getUsersByCity($city_id);
        return response()->json(['users' => $users], 201);
    }
}
