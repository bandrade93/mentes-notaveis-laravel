<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with('state')->get();

        if(empty($cities)) {
            return response()->json(['message' => 'Data does not exist.'], 203);
        }

        return response()->json($cities, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $city = City::with('state')->where('id', $id)->first();

        if(empty($city)) {
            return response()->json(['message' => 'Data does not exist.'], 203);
        }

        return response()->json($city, 201);
    }

}
