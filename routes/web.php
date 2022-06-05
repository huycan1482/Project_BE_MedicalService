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

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/postLogin', 'Auth\LoginController@postLogin')->name('postLogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/checkEmail', 'Auth\ForgotPasswordController@checkEmail')->name('checkEmail');
Route::post('/postCheckEmail', 'Auth\ForgotPasswordController@postCheckEmail')->name('postCheckEmail');

Route::get('/resetPassword', 'Auth\ResetPasswordController@resetPassword')->name('resetPassword');
Route::post('/postResetPassword', 'Auth\ResetPasswordController@postResetPassword')->name('postResetPassword');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'checkLogin'], function () {
// Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('nationality/trash', 'NationalityController@getDataWithTrashed')->name('nationality.trash');
    Route::get('nationality/forceDelete/{id}', 'NationalityController@forceDelete')->name('nationality.forceDelete');
    Route::get('nationality/restore/{id}', 'NationalityController@restore')->name('nationality.restore');
    Route::resource('nationality', 'NationalityController'); 
    
    Route::get('ethnic/trash', 'EthnicController@getDataWithTrashed')->name('ethnic.trash');
    Route::resource('ethnic', 'EthnicController'); 
    Route::get('ethnic/forceDelete/{id}', 'EthnicController@forceDelete')->name('ethnic.forceDelete');
    Route::get('ethnic/restore/{id}', 'EthnicController@restore')->name('ethnic.restore');

    Route::get('province/trash', 'ProvinceController@getDataWithTrashed')->name('province.trash');
    Route::resource('province', 'ProvinceController'); 
    Route::get('province/forceDelete/{id}', 'ProvinceController@forceDelete')->name('province.forceDelete');
    Route::get('province/restore/{id}', 'ProvinceController@restore')->name('province.restore');

    Route::get('district/trash', 'DistrictController@getDataWithTrashed')->name('district.trash');
    Route::get('district/getDistrictsByProvinceId/{id}', 'DistrictController@getDistrictsByProvinceId')->name('district.getDistrictsByProvinceId');
    Route::resource('district', 'DistrictController'); 
    Route::get('district/forceDelete/{id}', 'DistrictController@forceDelete')->name('district.forceDelete');
    Route::get('district/restore/{id}', 'DistrictController@restore')->name('district.restore');

    Route::get('ward/trash', 'WardController@getDataWithTrashed')->name('ward.trash');
    Route::get('ward/getWardsByDistrictId/{id}', 'WardController@getWardsByDistrictId')->name('ward.getWardsByDistrictId');
    Route::resource('ward', 'WardController'); 
    Route::get('ward/forceDelete/{id}', 'WardController@forceDelete')->name('ward.forceDelete');
    Route::get('ward/restore/{id}', 'WardController@restore')->name('ward.restore');

    Route::get('disease/trash', 'DiseaseController@getDataWithTrashed')->name('disease.trash');
    Route::resource('disease', 'DiseaseController'); 
    Route::get('disease/forceDelete/{id}', 'DiseaseController@forceDelete')->name('disease.forceDelete');
    Route::get('disease/restore/{id}', 'DiseaseController@restore')->name('disease.restore');

    Route::get('producer/trash', 'ProducerController@getDataWithTrashed')->name('producer.trash');
    Route::get('producer/getActiveProducersByVaccineId/{id}', 'ProducerController@getActiveProducersByVaccineId')->name('producer.getActiveProducersByVaccineId');
    Route::resource('producer', 'ProducerController'); 
    Route::get('producer/forceDelete/{id}', 'ProducerController@forceDelete')->name('producer.forceDelete');
    Route::get('producer/restore/{id}', 'ProducerController@restore')->name('producer.restore');

    Route::get('vaccine/trash', 'VaccineController@getDataWithTrashed')->name('vaccine.trash');
    Route::get('vaccine/getVaccinesByDiseaseId/{id}', 'VaccineController@getVaccinesByDiseaseId')->name('vaccine.getVaccinesByDiseaseId');
    Route::resource('vaccine', 'VaccineController'); 
    Route::get('vaccine/forceDelete/{id}', 'VaccineController@forceDelete')->name('vaccine.forceDelete');
    Route::get('vaccine/restore/{id}', 'VaccineController@restore')->name('vaccine.restore');

    Route::get('pack/trash', 'PackController@getDataWithTrashed')->name('pack.trash');
    Route::get('pack/getActivePacksByVaccineId/{id}', 'PackController@getActivePacksByVaccineId')->name('pack.getActivePacksByVaccineId');
    Route::resource('pack', 'PackController'); 
    Route::get('pack/forceDelete/{id}', 'PackController@forceDelete')->name('pack.forceDelete');
    Route::get('pack/restore/{id}', 'PackController@restore')->name('pack.restore');

    Route::get('priority/trash', 'PriorityController@getDataWithTrashed')->name('priority.trash');
    Route::resource('priority', 'PriorityController'); 
    Route::get('priority/forceDelete/{id}', 'PriorityController@forceDelete')->name('priority.forceDelete');
    Route::get('priority/restore/{id}', 'PriorityController@restore')->name('priority.restore');

    Route::get('role/trash', 'RoleController@getDataWithTrashed')->name('role.trash');
    Route::get('role/getRolesByWardId/{id}', 'RoleController@getRoleByWardId')->name('role.getRolesByWardId'); 
    Route::resource('role', 'RoleController'); 
    Route::get('role/forceDelete/{id}', 'RoleController@forceDelete')->name('role.forceDelete');
    Route::get('role/restore/{id}', 'RoleController@restore')->name('role.restore');

    Route::get('user/trash', 'UserController@getDataWithTrashed')->name('user.trash');
    Route::resource('user', 'UserController'); 
    Route::get('user/forceDelete/{id}', 'UserController@forceDelete')->name('user.forceDelete');
    Route::get('user/restore/{id}', 'UserController@restore')->name('user.restore');

    Route::get('resident/trash', 'ResidentController@getDataWithTrashed')->name('resident.trash');
    Route::get('resident/listInjections/{id}', 'ResidentController@getListInjections')->name('resident.listInjections');
    Route::resource('resident', 'ResidentController'); 
    Route::get('resident/forceDelete/{id}', 'ResidentController@forceDelete')->name('resident.forceDelete');
    Route::get('resident/restore/{id}', 'ResidentController@restore')->name('resident.restore');
    Route::get('searchResidents', 'ResidentController@searchResidents')->name('resident.search');

    Route::get('session/trash', 'SessionController@getDataWithTrashed')->name('session.trash');
    Route::resource('session', 'SessionController'); 
    Route::get('session/forceDelete/{id}', 'SessionController@forceDelete')->name('session.forceDelete');
    Route::get('session/restore/{id}', 'SessionController@restore')->name('session.restore');

    Route::get('object/trash/{id}', 'InjectionObjectController@getDataWithTrashed')->name('object.trash');
    Route::resource('object', 'InjectionObjectController'); 
    Route::get('object/forceDelete/{id}', 'InjectionObjectController@forceDelete')->name('object.forceDelete');
    Route::get('object/restore/{id}', 'InjectionObjectController@restore')->name('object.restore');
    Route::get('object/listObjects/{id}', 'InjectionObjectController@getListObjects')->name('object.listObjects');

    Route::get('injection/create/{resident_id}', 'InjectionController@create')->name('injection.create');
    Route::resource('injection', 'InjectionController'); 
    Route::get('injection/forceDelete/{id}', 'InjectionController@forceDelete')->name('injection.forceDelete');
    Route::get('injection/restore/{id}', 'InjectionController@restore')->name('injection.restore');

    Route::get('statistic', 'StatisticsController@index')->name('statistic.index');

    //StatisticsController
    Route::get('statistics/', 'StatisticsController@index')->name('statistics.index');

    Route::get('exceptions/', function () {
        return view ('admin.exceptions.index');
    });

    // ImportController
    // ImportProvince
    Route::post('import/province', 'ImportController@ImportProvince')->name('import.province');
    // ImportNationality
    Route::post('import/nationality', 'ImportController@ImportNationality')->name('import.nationality');
    // ImportDistrict
    Route::post('import/district', 'ImportController@ImportDistrict')->name('import.district');
    // ImportWard
    Route::post('import/ward', 'ImportController@ImportWard')->name('import.ward');
    // ImportObject
    Route::post('import/object', 'ImportController@ImportObject')->name('import.object');


    //Errors Controller 
    Route::get('/404', function () {
        return view ('errors.4xx', [
            'status' => '404!',
            'msg' => 'Trang bạn tìm kiếm không tồn tại'
        ]);
    })->name('errors.4xx');
});