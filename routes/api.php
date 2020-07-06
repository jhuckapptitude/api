<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::resource('puntos', 'PuntosController');

Route::get('puntos/cercanos/{id}/{limite?}', 'PuntosController@cercanos');

Route::get('puntos', 'PuntosController@index');

Route::get('puntos/{id}', 'PuntosController@show');

Route::post('puntos/', 'PuntosController@store');

Route::put('puntos/{id}', 'PuntosController@update');

Route::delete('puntos/{id}', 'PuntosController@destroy');