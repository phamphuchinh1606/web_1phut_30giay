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

Route::get('/employee','EmployeeController@index')->name('employee');
Route::get('/employee/create','EmployeeController@showCreate')->name('employee.create');
Route::post('/employee/create','EmployeeController@create')->name('employee.create');
Route::get('/employee/update/{id}','EmployeeController@showUpdate')->name('employee.update');
Route::post('/employee/update/{id}','EmployeeController@update')->name('employee.update');
Route::post('/employee/add-role/{id}','EmployeeController@addRoleEmployee')->name('employee.add_role');
Route::delete('/employee/delete-role/{id}/{employee_role_id}','EmployeeController@deleteRoleEmployee')->name('employee.delete_role');
Route::delete('/employee/delete/{id}','EmployeeController@delete')->name('employee.delete');


