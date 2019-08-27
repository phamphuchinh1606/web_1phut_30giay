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
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login-admin','Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login-admin','Auth\LoginController@login')->name('admin.login');
    Route::get('/logout-admin','Auth\LoginController@logout')->name('admin.logout');
});

Route::get('/login','Auth\LoginEmployeeController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginEmployeeController@login')->name('login');
Route::get('/logout','Auth\LoginEmployeeController@logout')->name('logout');
Route::get('/','Auth\LoginEmployeeController@showLoginForm')->name('employee.login');
