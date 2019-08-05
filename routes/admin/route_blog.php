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

Route::get('/blog','BlogController@index')->name('blog.index');
Route::get('/blog/create','BlogController@showCreate')->name('blog.create');
Route::post('/blog/create','BlogController@store')->name('blog.create');
Route::get('/blog/update/{id}','BlogController@showUpdate')->name('blog.update');
Route::post('/blog/update/{id}','BlogController@update')->name('blog.update');


