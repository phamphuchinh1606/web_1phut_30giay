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
Route::get('/setting/role','RoleController@index')->name('setting.role');
Route::get('/setting/role/update/{id}','RoleController@showUpdate')->name('setting.role.update');
Route::post('/setting/role/update/{id}','RoleController@update')->name('setting.role.update');
Route::delete('/setting/role/delete/{id}','RoleController@index')->name('setting.role.delete');
Route::delete('/setting/role/screen/delete/{id}/{screen_id}','RoleController@deleteRolePermission')->name('setting.role.screen.delete');