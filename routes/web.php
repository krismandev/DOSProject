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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get("/login","AuthController@login")->name("login");

Route::post("/login","AuthController@postLogin")->name("postLogin");

Route::get("/logout","AuthController@logout")->name("logout");

Route::get("/laporan_dos","DOSController@reportDOS")->name("reportDOS");

Route::group(['prefix' => 'spv'],function(){
    Route::get('/','SpvController@getSpv')->name('getSpv');
    Route::post('/','SpvController@storeSpv')->name('storeSpv');
});
