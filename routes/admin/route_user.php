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

Route::get('/user','UserController@index')->name('user');
Route::get('/user/create','UserController@showCreate')->name('user.create');
Route::post('/user/create','UserController@create')->name('user.create');
Route::get('/user/update/{id}','UserController@showUpdate')->name('user.update');
Route::post('/user/update/{id}','UserController@update')->name('user.update');
Route::post('/user/add-role/{id}','UserController@addRoleUser')->name('user.add_role');
Route::delete('/user/delete-role/{id}/{user_role_id}','EmployeeController@deleteRoleUser')->name('user.delete_role');
Route::delete('/user/delete/{id}','UserController@delete')->name('user.delete');


