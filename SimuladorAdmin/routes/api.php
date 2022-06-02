<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Parameters;

Route::get('/simulatorState','RoomSettingController@GetSimulatorState')->name('api.state');
Route::get('/setState/{state}', 'RoomSettingController@SetState');
Route::get('/getRoomSetting', 'RoomSettingController@GetRoomSettings');
Route::get('/pause', 'ParametersController@Pause')->name('api.pause');
Route::get('/shootingTarget/{time}/{site_shooting}/{target}', 'RoomSettingController@ShootingTarget');

Route::get('/getShootingTarget', 'RoomSettingController@GetShootingTarget')->name('api.getShooting');

Route::post('/getRoomSetting/{roomSetting}', 'RoomSettingController@GetRoomSetting');

