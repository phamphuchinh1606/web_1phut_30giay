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

Route::get('/admin','HomeController@index')->name('home');

Route::get('/setting/setting-of-day','SettingOfDayController@index')->name('setting.setting_of_day');




