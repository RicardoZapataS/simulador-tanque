<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Parameters;

Route::get('/simulatorState', function (Request $request) {
    $state = Parameters::find(1);
    return $state;
});
Route::get('/setLowState', function (Request $request) {
    $state = Parameters::find(1);
    $state->value = 1;
    $state->save();
    return $state;

});
Route::get('/getRoomSettings', function (Request $request) {
    $state = Parameters::find(3);
    $roomSetting = RoomSetting::find($state->value);
    return $roomSetting;
});

Route::post('/getRoomSetting/{roomSetting}', 'RoomSettingController@GetRoomSetting');

