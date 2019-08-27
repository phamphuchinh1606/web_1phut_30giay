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
Route::get('/sale-cart-small','SaleCartSmallController@index')->name('sale_card_small');
Route::post('/sale-cart-small/update-sale-cart-small.js','SaleCartSmallController@updateSaleCartSmall')->name('sale_card_small.update');





