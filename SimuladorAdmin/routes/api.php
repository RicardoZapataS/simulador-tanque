<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Parameters;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/simulatorState', function (Request $request) {
    $state = Parameters::find(1);
    return $state;
});
Route::get('/setStart', function (Request $request) {
    $state = Parameters::find(1);
    $state->value = 1;
    $state->save();
    return $state;

});
