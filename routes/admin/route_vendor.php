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

Route::get('/vendor','VendorController@index')->name('vendor.index');
Route::get('/vendor/create','VendorController@showCreate')->name('vendor.create');
Route::post('/vendor/create','VendorController@store')->name('vendor.create');
Route::get('/vendor/update/{id}','VendorController@showUpdate')->name('vendor.update');
Route::post('/vendor/update/{id}','VendorController@update')->name('vendor.update');


