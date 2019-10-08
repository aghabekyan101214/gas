<?php

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
    return redirect('/admin');
});

Auth::routes();

Route::get('files', 'FileReadController@start');
Route::get('sync', 'SyncController@start');
Route::get("client-side", "ClientSideController@index");
Route::post("get-client", "ClientSideController@getClientByQr");
Route::group(['prefix' => 'admin', 'middleware' => ['auth', "checkRole"]], function(){
    Route::get('/', 'HomeController@index');
    Route::resource('users', 'UserController');
    Route::resource('stations', 'StationController');
    Route::resource('dispensers', 'DispenserController');
    Route::resource('static-data', 'StaticController');
    Route::resource('clients', 'ClientController');
    Route::resource('fuels', 'FuelController');
});
Route::resource('bonus', 'BonusController');
Route::post("redeem", "BonusController@redeem");
