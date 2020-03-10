<?php

use Illuminate\Http\Request;

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

Route::post('cities', 'API\CityController@store');
Route::post('cities/{city}/delivery-times', 'API\CityController@attatchDeliveryTimes');
Route::post('delivery-times', 'API\DeliveryTimeController@store');
Route::post('cities/{city}/exclude-date', 'API\CityController@excludeDate');
