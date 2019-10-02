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

Route::group(['prefix' => 'admin','middleware' => ['auth']], function(){
    Route::get('/', 'HomeController@index');
    Route::resource('users', 'UserController')->middleware("checkRole");
    Route::resource('stations', 'StationController')->middleware("checkRole");
    Route::resource('clients', 'ClientController');
    Route::resource('dispensers', 'DispenserController');
    Route::resource('fuels', 'FuelController');
});
Route::resource('bonus', 'BonusController');
