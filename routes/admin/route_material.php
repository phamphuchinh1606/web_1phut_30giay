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

Route::get('/setting/material','MaterialController@index')->name('material');
Route::get('/setting/material/create','MaterialController@showCreate')->name('material.create');
Route::post('/setting/material/create','MaterialController@create')->name('material.create');
Route::get('/setting/material/update/{id}','MaterialController@showUpdate')->name('material.update');
Route::post('/setting/material/update/{id}','MaterialController@update')->name('material.update');
Route::delete('/setting/material/delete/{id}','MaterialController@delete')->name('material.delete');
