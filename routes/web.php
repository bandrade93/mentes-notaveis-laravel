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

//state routes
Route::get('/states', 'StateController@index');
Route::get('/states/{id}', 'StateController@show');

//city routes
Route::get('/cities', 'CityController@index');
Route::get('/cities/{id}', 'CityController@show');

//address routes
Route::get('/address', 'AddressController@index');
Route::get('/address/{id}', 'AddressController@show');
Route::post('/address', 'AddressController@store');

//user routes
Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@show');
Route::post('/users', 'UserController@store');
Route::put('/users/{id}', 'UserController@update');
Route::delete('/users/{id}', 'UserController@destroy');
Route::get('/users/getManyUserByState/{id}', 'UserController@getManyUserByState');
Route::get('/users/getManyUserByCity/{id}', 'UserController@getManyUserByCity');
