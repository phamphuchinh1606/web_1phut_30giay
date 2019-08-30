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

Route::get('/setting/user','UserController@index')->name('user');
Route::get('/setting/user/create','UserController@showCreate')->name('user.create');
Route::post('/setting/user/create','UserController@create')->name('user.create');
Route::get('/setting/user/update/{id}','UserController@showUpdate')->name('user.update');
Route::post('/setting/user/update/{id}','UserController@update')->name('user.update');
Route::post('/setting/user/add-role/{id}','UserController@addRoleUser')->name('user.add_role');
Route::delete('/setting/user/delete-role/{id}/{user_role_id}','UserController@deleteRoleUser')->name('user.delete_role');
Route::delete('/setting/user/delete/{id}','UserController@delete')->name('user.delete');


