<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();

        if(empty($states)) {
            return response()->json(['message' => 'Data does not exist.'], 203);
        }

        return response()->json($states, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $state = State::find($id);

        if(empty($state)) {
            return response()->json(['message' => 'Data does not exist.'], 203);
        }

        return response()->json($state, 201);
    }

}
