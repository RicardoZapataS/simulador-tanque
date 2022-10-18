<?php

use Illuminate\Support\Facades\Route;



Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/setStart', 'ParametersController@SetStart')->name('setStart');

Route::middleware(['auth'])->group(function () {

    Route::get('/', 'MainController@index')->name('index');
    Route::post('/startSimulator', 'MainController@StartRoom')->name('startSimulator');
    Route::get('/simulator-screen', 'MainController@SimulatorScreem')->name('simulator');
    Route::get('/historial', 'PointController@index')->name('historial');
    Route::get('/historial/ver', 'PointController@general')->name('historial.general');
    Route::get('/historial/ver/{id}', 'PointController@personal')->name('historial.personal');
    Route::get('/historial/print/{id}', 'PointController@print')->name('historial.print');
    Route::get('/historial/{id}/ver', 'PointController@show')->name('historial.ver');

    Route::get('/usuario/admin', 'UserController@admin')->name('usuario.admin');
    Route::resource('usuario', UserController::class);

});
