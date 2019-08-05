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


Route::get('/albums','AlbumController@albumList')->name('album.album');
Route::post('albums/create','AlbumController@albumCreate')->name('album.create');
Route::post('/albums/update','AlbumController@albumUpdate')->name('album.update');
Route::delete('albums/delete/{id}','AlbumController@albumDestroy')->name('album.delete');



