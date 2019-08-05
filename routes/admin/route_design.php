<?php


Route::get('/designs','DesignController@index')->name('design.index');
Route::get('/designs/create','DesignController@showCreate')->name('design.create');
Route::post('/designs/create','DesignController@store')->name('design.create');
Route::get('designs/update/{id}','DesignController@showUpdate')->name('design.update');
Route::post('designs/update/{id}','DesignController@update')->name('design.update');
Route::post('/designs/image/add/{productId}','DesignController@addProductImage')->name('design.image.add');
Route::delete('/designs/image/delete/{productId}/{id}','DesignController@deleteProductImage')->name('design.image.delete');
Route::delete('/designs/delete/{id}','DesignController@delete')->name('design.delete');


Route::get('/design-type','DesignTypeController@index')->name('design_type.index');
Route::get('/design-type/create','DesignTypeController@showCreate')->name('design_type.create');
Route::post('/design-type/create','DesignTypeController@store')->name('design_type.create');
Route::get('/design-type/update/{id}','DesignTypeController@showUpdate')->name('design_type.update');
Route::post('/design-type/update/{id}','DesignTypeController@update')->name('design_type.update');
Route::post('/design-type/create-children/{id}','DesignTypeController@createProductTypeChildren')->name('design_type.create_children');
Route::delete('/design-type/delete-children/{id}/{childId}','DesignTypeController@deleteProductTypeChildren')->name('design_type.delete_children');