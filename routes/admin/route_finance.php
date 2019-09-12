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
Route::get('/finance','FinanceController@index')->name('finance');
Route::post('/finance/create','FinanceController@create')->name('finance.create');
Route::get('/finance/update/{id}','FinanceController@index')->name('finance.update');
Route::post('/finance/update/{id}','FinanceController@update')->name('finance.update');
Route::delete('/finance/delete/{id}','FinanceController@delete')->name('finance.delete');
Route::get('/finance/get-sale-amount','FinanceController@getFinanceSaleAmount')->name('finance.get_sale_amount');



