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
Route::get('/','PrepareMaterialController@index')->name('home');
Route::get('/home','PrepareMaterialController@index');
//Route::get('/',function(){
//    return redirect()->route('prepare_material');
//})->name('home');
//Route::get('/home',function(){
//    return redirect()->route('prepare_material');
//});
