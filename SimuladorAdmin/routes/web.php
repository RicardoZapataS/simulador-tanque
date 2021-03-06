<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/setStart', 'ParametersController@SetStart')->name('setStart');

Route::middleware(['auth'])->group(function () {

    Route::get('/', 'MainController@index')->name('index');
    Route::post('/startSimulator', 'MainController@StartRoom')->name('startSimulator');
    Route::get('/simulator-screen', 'MainController@SimulatorScreem')->name('simulator');

    Route::resource('usuario', UserController::class);

});
