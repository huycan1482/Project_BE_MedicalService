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

    Route::get('district/getDistrictsByProvinceId/{id}', 'DistrictController@getDistrictsByProvinceId')->name('district.getDistrictsByProvinceId');
    Route::resource('district', 'DistrictController'); 
    Route::get('district/forceDelete/{id}', 'DistrictController@forceDelete')->name('district.forceDelete');
    Route::get('district/restore/{id}', 'DistrictController@restore')->name('district.restore');

    Route::get('ward/getWardsByDistrictId/{id}', 'WardController@getWardsByDistrictId')->name('ward.getWardsByDistrictId');
    Route::resource('ward', 'WardController'); 
    Route::get('ward/forceDelete/{id}', 'WardController@forceDelete')->name('ward.forceDelete');
    Route::get('ward/restore/{id}', 'WardController@restore')->name('ward.restore');

    Route::resource('disease', 'DiseaseController'); 
    Route::get('disease/forceDelete/{id}', 'DiseaseController@forceDelete')->name('disease.forceDelete');
    Route::get('disease/restore/{id}', 'DiseaseController@restore')->name('disease.restore');

    Route::resource('producer', 'ProducerController'); 
    Route::get('producer/forceDelete/{id}', 'ProducerController@forceDelete')->name('producer.forceDelete');
    Route::get('producer/restore/{id}', 'ProducerController@restore')->name('producer.restore');

    Route::resource('vaccine', 'VaccineController'); 
    Route::get('vaccine/forceDelete/{id}', 'VaccineController@forceDelete')->name('vaccine.forceDelete');
    Route::get('vaccine/restore/{id}', 'VaccineController@restore')->name('vaccine.restore');

    Route::resource('priority', 'PriorityController'); 
    Route::get('priority/forceDelete/{id}', 'PriorityController@forceDelete')->name('priority.forceDelete');
    Route::get('priority/restore/{id}', 'PriorityController@restore')->name('priority.restore');

    Route::get('role/getRolesByWardId/{id}', 'RoleController@getRoleByWardId')->name('role.getRolesByWardId'); 
    Route::resource('role', 'RoleController'); 
    Route::get('role/forceDelete/{id}', 'RoleController@forceDelete')->name('role.forceDelete');
    Route::get('role/restore/{id}', 'RoleController@restore')->name('role.restore');

    Route::resource('user', 'UserController'); 
    Route::get('user/forceDelete/{id}', 'UserController@forceDelete')->name('user.forceDelete');
    Route::get('user/restore/{id}', 'UserController@restore')->name('user.restore');

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