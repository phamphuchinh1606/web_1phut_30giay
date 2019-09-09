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
Route::get('/check-in-daily','CheckInController@daily')->name('check_in.daily');
Route::get('/check-in-charge/{id?}', 'CheckInController@checkInCharge')->name('check_in.check_in_charge');
Route::post('/check-in-charge-create', 'CheckInController@createCheckInCharge')->name('check_in.check_in_charge.create');
Route::get('/check-in-charge-update/{id}', 'CheckInController@showUpdateCheckInCharge')->name('check_in.check_in_charge.update');
Route::post('/check-in-charge-update/{id}', 'CheckInController@updateCheckInCharge')->name('check_in.check_in_charge.update');
Route::delete('/check-in-charge-delete/{id}', 'CheckInController@delete')->name('check_in.check_in_charge.delete');



