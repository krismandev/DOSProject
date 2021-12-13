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
Route::get("/laporan_dos/approve/{id}","DOSController@approveDOS")->name("approveDOS");
Route::get("/laporan_dos/decline/{id}","DOSController@declineDOS")->name("declineDOS");


Route::group(['prefix' => 'spv'],function(){
    Route::get('/','SpvController@getSpv')->name('getSpv');
    Route::post('/','SpvController@storeSpv')->name('storeSpv');
});

Route::group(['prefix' => 'sf'],function(){
    Route::get('/','SfController@getSf')->name('getSf');
    Route::post('/','SfController@storeSf')->name('storeSf');
});

Route::group(['prefix' => 'agencies'],function(){
    Route::get('/','AgencyController@getAgency')->name('getAgency');
    Route::post('/','AgencyController@storeAgency')->name('storeAgency');
});
