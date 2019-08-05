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

Route::post('/upload-image-quill-editor','Controller@uploadImageQuillEditor')->name('common.upload_image_editor');
Route::get('/upload-image-quill-editor','Controller@uploadImageQuillEditor')->name('common.upload_image_editor');
Route::post('/upload-image','Controller@uploadImage')->name('common.upload_image');
Route::post('/delete-image','Controller@deleteImage')->name('common.delete_image');


