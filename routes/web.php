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




Route::group(['middleware' => ['auth','checkRole:pic,spv']], function(){
    Route::get("/laporan_dos","DOSController@reportDOS")->name("reportDOS");
    Route::get('/maps','MapsController@getMaps')->name('getMaps');

});


Route::group(['middleware' => ['auth','checkRole:pic']], function(){
    Route::get("/laporan_dos/approve/{id}","DOSController@approveDOS")->name("approveDOS");
    Route::get("/laporan_dos/decline/{id}","DOSController@declineDOS")->name("declineDOS");
});


Route::group(['middleware' => ['auth','checkRole:pic,admin']], function(){
    Route::get('/maps','MapsController@getMaps')->name('getMaps');

    Route::get("/laporan_dos","DOSController@reportDOS")->name("reportDOS");
    Route::group(['prefix' => 'dashboard'],function(){
        Route::get('/dos_per_spv','DashboardDataController@dashDosPerSpv')->name('dashDosPerSpv');
        Route::get('/dos_per_spv/filter','DashboardDataController@dashDosPerSpvFiltered')->name('dashDosPerSpvFiltered');

        Route::get('/dos_per_sales','DashboardDataController@dashDosPerSales')->name('dashDosPerSales');
        Route::get('/dos_per_sales/filter','DashboardDataController@dashDosPerSalesFiltered')->name('dashDosPerSalesFiltered');

        Route::get('/evaluasidossf','DashboardDataController@dashEvaluasiDosSf')->name('dashEvaluasiDosSf');
        Route::get('/evaluasidossf/filter','DashboardDataController@dashEvaluasiDosSfFiltered')->name('dashEvaluasiDosSfFiltered');
        Route::get('/evaluasidossf/detail_hasil/filterspv/{spv_id}','DashboardDataController@detailHasilDosPerSpv')->name('detailHasilDosPerSpv');

    });

    Route::group(['prefix' => 'rekap-dos'],function(){
        Route::get('/','DOSController@getRekapDos')->name('getRekapDos');
        Route::get('/spv/{id}','DOSController@getRekapDosBySpv')->name('getRekapDosBySpv');
        Route::get('/spv/{id}/data/{awal}/{akhir}','DOSController@dataRekapDosBySpv')->name('dataRekapDosBySpv');
        Route::get('/spv/{id}/data/{awal}/{akhir}/export','DOSController@exportDataDos')->name('exportDataDos');
        // Route::post('/','AgencyController@storeAgency')->name('storeAgency');
    });

    Route::group(['prefix' => 'sales_plan'],function(){
        Route::get('/','SalesPlanController@getSalesPlan')->name('getSalesPlan');
        Route::get('/create','SalesPlanController@createSalesPlan')->name('createSalesPlan');
        Route::post('/','SalesPlanController@storeSalesPlan')->name('storeSalesPlan');

        Route::get('/add-kelurahan','SalesPlanController@addKelurahan')->name('addKelurahan');

    });

    Route::group(['prefix' => 'odp'],function(){
        Route::get('/','OdpController@getOdp')->name('getOdp');
        Route::post('/','OdpController@importOdp')->name('importOdp');
    });

    Route::group(['prefix' => 'kelurahan'],function(){
        Route::get('/','KelurahanController@getKelurahan')->name('getKelurahan');
        Route::post('/','KelurahanController@importKelurahan')->name('importKelurahan');
    });
});


Route::group(['middleware' => ['auth','checkRole:admin']], function(){
    Route::group(['prefix' => 'spv'],function(){
        Route::get('/','SpvController@getSpv')->name('getSpv');
        Route::post('/','SpvController@storeSpv')->name('storeSpv');
        Route::patch('/','SpvController@updateSpv')->name('updateSpv');
    });

    Route::group(['prefix' => 'sf'],function(){
        Route::get('/','SfController@getSf')->name('getSf');
        Route::post('/','SfController@storeSf')->name('storeSf');
        Route::patch('/','SfController@updateSf')->name('updateSf');
    });

    Route::group(['prefix' => 'agencies'],function(){
        Route::get('/','AgencyController@getAgency')->name('getAgency');
        Route::post('/','AgencyController@storeAgency')->name('storeAgency');
        Route::patch('/','AgencyController@updateAgency')->name('updateAgency');
    });

    Route::group(['prefix' => 'pic'],function(){
        Route::get('/','PicController@getPic')->name('getPic');
        Route::post('/','PicController@storePic')->name('storePic');
        Route::patch('/','PicController@updatePic')->name('updatePic');
    });
});

Route::get("kirim_bot/{pesan}","BotController@sendMessage")->name("sendMessage");
Route::get("hook","BotController@hook")->name("hook");
