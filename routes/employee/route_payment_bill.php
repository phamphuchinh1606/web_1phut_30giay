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
Route::get('/payment-bill','PaymentBillController@index')->name('payment_bill');
Route::post('/payment-bill/create','PaymentBillController@create')->name('payment_bill.create');
Route::get('/payment-bill/update/{id}','PaymentBillController@index')->name('payment_bill.update');
Route::post('/payment-bill/update/{id}','PaymentBillController@update')->name('payment_bill.update');
Route::delete('/payment-bill/delete/{id}','PaymentBillController@delete')->name('payment_bill.delete');





