<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Address;

class AddressController extends Controller
{
    public function index()
    {
        $address = Address::with('city.state')->get();

        if(!$address) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response(AddressResource::collection($address), 201);
    }

    public function show(int $id)
    {
        $address = Address::with('city.state')
            ->where('id', $id)
            ->first();

        if(!$address) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response(AddressResource::collection($address), 201);
    }

}
