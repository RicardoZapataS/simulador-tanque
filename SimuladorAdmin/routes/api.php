<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Parameters;

Route::get('/simulatorState','RoomSettingController@GetSimulatorState')->name('api.state');
Route::get('/setLowState', 'RoomSettingController@SetLowState');
Route::get('/getRoomSetting', 'RoomSettingController@GetRoomSettings');
Route::get('/pause', 'ParametersController@Pause')->name('api.pause');

Route::post('/getRoomSetting/{roomSetting}', 'RoomSettingController@GetRoomSetting');

