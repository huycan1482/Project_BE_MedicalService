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
    Route::resource('nationality', 'NationalityController'); 
    Route::get('nationality/forceDelete/{id}', 'NationalityController@forceDelete')->name('province.forceDelete');
    Route::get('nationality/restore/{id}', 'NationalityController@restore')->name('province.restore');

    Route::resource('province', 'ProvinceController'); 
    Route::get('province/forceDelete/{id}', 'ProvinceController@forceDelete')->name('province.forceDelete');
    Route::get('province/restore/{id}', 'ProvinceController@restore')->name('province.restore');

    Route::resource('district', 'DistrictController'); 
    Route::get('district/forceDelete/{id}', 'DistrictController@forceDelete')->name('district.forceDelete');
    Route::get('district/restore/{id}', 'DistrictController@restore')->name('district.restore');

    Route::resource('ward', 'WardController'); 
    Route::get('ward/forceDelete/{id}', 'WardController@forceDelete')->name('ward.forceDelete');
    Route::get('ward/restore/{id}', 'WardController@restore')->name('ward.restore');

    Route::resource('disease', 'DiseaseController'); 
    Route::get('disease/forceDelete/{id}', 'DiseaseController@forceDelete')->name('disease.forceDelete');
    Route::get('disease/restore/{id}', 'DiseaseController@restore')->name('disease.restore');

    // ImportController
    // ImportProvince
    Route::post('import/province', 'ImportController@ImportProvince')->name('import.province');
    // ImportNationality
    Route::post('import/nationality', 'ImportController@ImportNationality')->name('import.nationality');
    // ImportDistrict
    Route::post('import/district', 'ImportController@ImportDistrict')->name('import.district');
    // ImportWard
    Route::post('import/ward', 'ImportController@ImportWard')->name('import.ward');

});