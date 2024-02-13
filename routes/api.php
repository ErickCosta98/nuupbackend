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

//ruta para almacenar los likes
Route::post('/likes', 'App\Http\Controllers\LikesController@store');

//ruta para obtener los likes de una fecha
Route::get('/likes/{date}', 'App\Http\Controllers\LikesController@show');
