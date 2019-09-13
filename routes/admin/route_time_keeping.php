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

Route::get('/time-keeping','TimeKeepingController@index')->name('time_keeping');
Route::post('/time-keeping/update-time-keeping.js','TimeKeepingController@updateTimeKeeping')->name('time_keeping.update');
Route::get('/time-keeping/print-view/{id?}','TimeKeepingController@printViewTimeKeeping')->name('time_keeping.print_view');


