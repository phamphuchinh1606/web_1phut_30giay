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
Route::get('/setting/menu','MenuController@index')->name('setting.menu');
Route::get('/setting/menu/create','MenuController@showCreate')->name('setting.menu.create');
Route::post('/setting/menu/create','MenuController@create')->name('setting.menu.create');
Route::get('/setting/menu/update/{id}','MenuController@showUpdate')->name('setting.menu.update');
Route::post('/setting/menu/update/{id}','MenuController@update')->name('setting.menu.update');
Route::delete('/setting/menu/delete/{id}','MenuController@delete')->name('setting.menu.delete');
