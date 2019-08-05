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

Route::get('/admin','HomeController@index')->name('home');

Route::get('/setting/banner','SettingController@bannerList')->name('setting.banner');
Route::post('setting/banner/create','SettingController@bannerCreate')->name('setting.banner.create');
Route::post('/setting/banner/update','SettingController@bannerUpdate')->name('setting.banner.update');
Route::delete('setting/banner/delete/{id}','SettingController@bannerDestroy')->name('setting.banner.delete');

//Setting Top Banner
Route::get('/setting/top-banner','SettingController@topBannerList')->name('setting.topBanner');
Route::post('/setting/top-banner/create','SettingController@topBannerCreate')->name('setting.topBanner.create');
Route::delete('setting/top-banner/delete/{id}','SettingController@topBannerDestroy')->name('setting.topBanner.delete');

//Setting Tags
Route::get('/setting/tag','SettingController@tagList')->name('setting.tag');
Route::post('/setting/tag/create','SettingController@tagCreate')->name('setting.tag.create');
Route::delete('setting/tag/delete/{id}','SettingController@tagDestroy')->name('setting.tag.delete');

//Setting App Info
Route::get('/setting/app-info','SettingController@appInfo')->name('setting.app');
Route::post('/setting/app-info/update','SettingController@updateAppInfo')->name('setting.app.update');

//Setting About Info
Route::get('/setting/app-about','SettingController@appAboutUpdate')->name('setting.app_about.show');
Route::post('/setting/app-about/update','SettingController@updateAboutAppInfo')->name('setting.app_about');

//Setting Out Source Info
Route::get('/setting/app-out-source','SettingController@appOutSourceUpdate')->name('setting.app_out_source.show');
Route::post('/setting/app-out-source/update','SettingController@updateOutSourceAppInfo')->name('setting.app_out_source');




