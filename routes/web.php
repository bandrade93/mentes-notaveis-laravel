<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/menus', 'MenuController@index');

Route::get('states/getStates', 'StateController@list');
Route::get('cities/getCitiesByState/{state_id}', 'CityController@list');

Route::resources([
    'states' => 'StateController',
    'cities' => 'CityController',
    'users' => 'UserController',
]);

Route::patch('{controller}/enableMulti', 'Controller@enableMulti');
Route::patch('{controller}/disableMulti', 'Controller@disableMulti');
Route::patch('{controller}/deleteMulti', 'Controller@deleteMulti');

Route::get('/', 'UserController@index');