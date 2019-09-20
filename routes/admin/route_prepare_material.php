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
Route::get('/prepare-material','PrepareMaterialController@index')->name('prepare_material');
Route::post('/prepare-material/update','PrepareMaterialController@updatePrepareMaterial')->name('prepare_material.update');
Route::get('/prepare-material/print-view','PrepareMaterialController@printView')->name('prepare_material.printView');





