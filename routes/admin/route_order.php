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
Route::post('/order/detail/{id}/confirm', 'OrderController@statusConfirm')->name('order.detail.confirm');
Route::post('/order/detail/{id}/shipping', 'OrderController@statusShipping')->name('order.detail.shipping');
Route::post('/order/detail/{id}/finish', 'OrderController@statusFinish')->name('order.detail.finish');
Route::post('/order/detail/{id}/cancel', 'OrderController@statusCancel')->name('order.detail.cancel');
Route::get('/order/detail/{id}', 'OrderController@detail')->name('order.detail');
Route::get('/order','OrderController@index')->name('order.index');


