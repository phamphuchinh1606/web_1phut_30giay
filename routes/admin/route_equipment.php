<?php

Route::get('/equipments','EquipmentController@index')->name('equipment.index');
Route::get('/equipments/create','EquipmentController@showCreate')->name('equipment.create');
Route::post('/equipments/create','EquipmentController@store')->name('equipment.create');
Route::get('equipments/update/{id}','EquipmentController@showUpdate')->name('equipment.update');
Route::post('equipments/update/{id}','EquipmentController@update')->name('equipment.update');
Route::post('/equipments/image/add/{productId}','EquipmentController@addProductImage')->name('equipment.image.add');
Route::delete('/equipments/image/delete/{productId}/{id}','EquipmentController@deleteProductImage')->name('equipment.image.delete');
Route::delete('/equipments/delete/{id}','EquipmentController@delete')->name('equipment.delete');

Route::get('/equipment-type','EquipmentTypeController@index')->name('equipment_type.index');
Route::get('/equipment-type/create','EquipmentTypeController@showCreate')->name('equipment_type.create');
Route::post('/equipment-type/create','EquipmentTypeController@store')->name('equipment_type.create');
Route::get('/equipment-type/update/{id}','EquipmentTypeController@showUpdate')->name('equipment_type.update');
Route::post('/equipment-type/update/{id}','EquipmentTypeController@update')->name('equipment_type.update');
Route::post('/equipment-type/create-children/{id}','EquipmentTypeController@createProductTypeChildren')->name('equipment_type.create_children');
Route::delete('/equipment-type/delete-children/{id}/{childId}','EquipmentTypeController@deleteProductTypeChildren')->name('equipment_type.delete_children');