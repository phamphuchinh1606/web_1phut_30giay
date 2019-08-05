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

//Setting Manufacture
Route::get('/manufactures','ManufactureController@manufactureList')->name('manufacture.index');
Route::post('/manufacture/create','ManufactureController@manufactureCreate')->name('manufacture.create');
Route::delete('manufacture/delete/{id}','ManufactureController@manufactureDestroy')->name('manufacture.delete');



