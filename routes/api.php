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

Route::get('get_province' , 'ApiController@get_province');
Route::get('get_city/{province_id}', 'ApiController@get_city');
Route::get('get_pledge', 'ApiController@get_pledge');
Route::get('get_delivery', 'ApiController@get_delivery');
