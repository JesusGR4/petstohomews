<?php

use Illuminate\Http\Request;

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


//Ruta insignificante, sirve para iniciar el deb
Route::get('/home', function (Request $request) {
    return 'Hola';
});

//Rutas para el usuario
Route::post('/login', 'Auth\LoginController@login');
Route::post('/forgotPassword', 'ForgotPasswordController@sendResetEmail');
Route::post('/reset', 'ResetPasswordController@reset');
Route::post('/register', 'ParticularController@register');
Route::post('/getSheltersByProvince', 'ShelterController@getSheltersByProvince');


//Rutas para los tipos
//
//Route::group(['prefix' => 'types', 'middleware' => ['jwt.auth']], function () {
//    Route::get('/getTypes', 'TypeController@getTypes');
//});



