<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::all();

        if(!$menus) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response($menus);
    }
}