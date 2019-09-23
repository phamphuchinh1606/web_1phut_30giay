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
Route::get('/setting/screen','ScreenController@index')->name('setting.screen');
Route::get('/setting/screen/create','ScreenController@showCreate')->name('setting.screen.create');
Route::post('/setting/screen/create','ScreenController@create')->name('setting.screen.create');
Route::get('/setting/screen/update/{id}','ScreenController@showUpdate')->name('setting.screen.update');
Route::post('/setting/screen/update/{id}','ScreenController@update')->name('setting.screen.update');
Route::delete('/setting/screen/delete-screen','ScreenController@delete')->name('setting.screen.delete');
