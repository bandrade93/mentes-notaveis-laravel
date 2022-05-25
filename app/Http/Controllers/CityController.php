<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('state')->get();

        if(!$cities) {
            return response(['message' => 'Data does not exist.'], 404);
        }

        return response(CityResource::collection($cities));
    }

    public function show(int $id)
    {
        $cities = City::with('state')
            ->where('id', $id)
            ->get();

        if(!$cities) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response(CityResource::collection($cities), 201);
    }

}
