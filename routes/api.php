<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/clear-cache-all', function() {

    Artisan::call('cache:clear');
    dd("Cache Clear All");

});

Route::get('getCountry','ProvinceStatesController@getCountry');
Route::get('getCountryStates','CountryStatesController@getCountryStates');
Route::get('getExperiences','ExperiencesController@getExperiences');
Route::get('getTimeType','TimeTypeController@getTimeType');
Route::get('getTimeCurrency','CurrencyController@getCurrency');

Route::group(['namespace' => 'Auth'], function() {
	Route::post('register', 'RegisterController@register');
	Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name
	Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
	Route::post('login', 'AuthController@login');
});


Route::group(['namespace' => 'Auth','middleware' => ['auth.api']], function() {
    Route::get('logout', 'AuthController@logout'); 
});


Route::group(['namespace' => 'Helpers','middleware' => ['auth.api','CheckStatus']], function() {
	Route::post('filePicture','FilesController@filePicture');
	Route::post('fileOtherFormat','FilesController@fileOtherFormat');

});

Route::group(['namespace' => 'Chefe','middleware' => ['auth.api','CheckStatus','UserType']], function() {
	Route::post('create/cv','CVController@createCV');
	Route::get('getCVData/{id}','CVController@getCVData');

});

Route::group(['namespace' => 'Chefe','middleware' => ['auth.api','CheckStatus','UserType','CheckChefe']], function() {

});
