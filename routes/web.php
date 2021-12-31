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

use Illuminate\Support\Facades\Route;

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('province', 'ProvinceController'); 
    Route::get('province/forceDelete/{id}', 'ProvinceController@forceDelete')->name('province.forceDelete');
    Route::get('province/restore/{id}', 'ProvinceController@restore')->name('province.restore');

    Route::resource('district', 'DistrictController'); 
    Route::get('district/forceDelete/{id}', 'DistrictController@forceDelete')->name('district.forceDelete');
    Route::get('district/restore/{id}', 'DistrictController@restore')->name('district.restore');


    // ImportController
    Route::post('import/province', 'ImportController@importProvince')->name('import.province');


});