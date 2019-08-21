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
Route::post('/setting/setting-of-day/save','SettingOfDayController@saveSettingDay')->name('setting.setting_of_day.save');
Route::delete('/setting/setting-of-day/delete/{id}','SettingOfDayController@deleteSettingDay')->name('setting.setting_of_day.delete');

//Route Selected Branch Month
Route::post('/setting/update-selected-branch.js','SettingController@updateSelectedBranch')->name('setting.update_selected_branch');
Route::post('/setting/update-selected-month.js','SettingController@updateSelectedMonth')->name('setting.update_selected_month');




