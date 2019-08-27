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
Route::get('/input-daily/update-daily.js','InputDailyController@updateDaily')->name('input_daily.update_daily');
Route::post('/input-daily/update-daily.js','InputDailyController@updateDaily')->name('input_daily.update_daily');
Route::post('/input-daily/update-sale.js','InputDailyController@updateSale')->name('input_daily.update_sale');
Route::post('/input-daily/update-bill.js','InputDailyController@updateBill')->name('input_daily.update_bill');
Route::post('/input-daily/update-employee.js','InputDailyController@updateEmployee')->name('input_daily.update_Employee');
Route::get('/input-daily/{date?}','InputDailyController@index')->name('input_daily');





