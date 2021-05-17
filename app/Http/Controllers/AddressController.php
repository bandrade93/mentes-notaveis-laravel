<?php

namespace App\Http\Controllers;

use App\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $address = Address::with('state')->with('city')->get();

        return response()->json($address, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $address = Address::with('state')->with('city')->where('id', $id)->first();

        return response()->json($address, 201);
    }

}
