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

Route::post("/login","API\AuthController@login");

Route::post("/lapor_dos","API\DOSController@storeDos")->middleware("jwtAuth");

Route::get("/dos_today","API\DOSController@getTodayDos")->middleware("jwtAuth");
Route::get("/dos_today/{id}","API\DOSController@getDetailDos")->middleware("jwtAuth");

Route::get("/logout","API\AuthController@logout")->middleware("jwtAuth");

Route::post("/change_password","API\AuthController@changePassword")->middleware("jwtAuth");

Route::get("/kelurahan-sales-plan","API\DOSController@getKelurahanToday")->middleware("jwtAuth");
