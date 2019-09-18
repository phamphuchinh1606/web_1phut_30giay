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

Route::get('/setting/small-car','SmallCarController@index')->name('setting.small_car');
Route::get('/setting/small-car/create','SmallCarController@showCreate')->name('setting.small_car.create');
Route::post('/setting/small-car/create','SmallCarController@create')->name('setting.small_car.create');
Route::get('/setting/small-car/update/{id}','SmallCarController@showUpdate')->name('setting.small_car.update');
Route::post('/setting/small-car/update/{id}','SmallCarController@update')->name('setting.small_car.update');


