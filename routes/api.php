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
    $shelters = \App\Shelter::all();
    foreach($shelters as $shelter){

        $count = $shelter->hasManyAnimals()->count();
        dd($count);
    }
});

//Rutas para el usuario
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/forgotPassword', 'ForgotPasswordController@sendResetEmail');
Route::post('/reset', 'ResetPasswordController@reset');
Route::post('/register', 'ParticularController@register');
Route::post('/getSheltersByProvince', 'ShelterController@getSheltersByProvince');
Route::post('/getSheltersByProvincePaginate', 'ShelterController@getSheltersByProvincePaginate');
Route::post('/getShelterById', 'ShelterController@getShelterById');
Route::post('/createShelter', 'ShelterController@createShelter');
Route::post('/getAnimalsByShelterId', 'AnimalController@getAnimalsByShelterId');
Route::post('/getAnimalsByShelter', 'AnimalController@getAnimalsByShelter');
Route::post('/getAnimalById', 'AnimalController@getAnimalById');
//ADMIN ROUTES
Route::group(['prefix' => 'admin', 'middleware' => ['jwt.auth', 'admin']], function () {
    Route::post('/getPendingShelters', 'ShelterController@getPendingShelters');
    Route::post('/rejectShelter', 'ShelterController@rejectShelter');
    Route::post('/acceptShelter', 'ShelterController@acceptShelter');
});

//Particular ROUTES
Route::group(['prefix' => 'particular', 'middleware' => ['jwt.auth', 'particular']], function () {
    Route::get('/getParticular', 'ParticularController@getParticular');
    Route::post('/editProfile', 'ParticularController@updateProfile');

});

//Particular ROUTES
Route::group(['prefix' => 'shelter', 'middleware' => ['jwt.auth', 'shelter']], function () {
    Route::post('/getMyAnimals', 'AnimalController@getMyAnimals');
    Route::post('/createAnimal', 'AnimalController@createAnimal');
    Route::post('/deleteAnimal', 'AnimalController@deleteAnimal');

});
//Rutas para los tipos
//
//Route::group(['prefix' => 'types', 'middleware' => ['jwt.auth']], function () {
//    Route::get('/getTypes', 'TypeController@getTypes');
//});



