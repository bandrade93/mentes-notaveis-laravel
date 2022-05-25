<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\State;

class StateController extends Controller
{
    public function index()
    {
        $states = State::all();

        if(!$states) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response(StateResource::collection($states), 201);
    }

    public function show(int $id)
    {
        $states = State::where('id', $id)->get();

        if(!$states) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response(StateResource::collection($states), 201);
    }

}
