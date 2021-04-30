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

Route::post('/token/store', 'ApiTokenController@createAPIToken');
Route::put('/token/{id}/update', 'ApiTokenController@updateToken');
Route::delete('/token/{id}/delete', 'ApiTokenController@deleteToken');

Route::middleware(['token_ruang_hr'])->group(function () {
    Route::post('/pekerjaan/store', 'PekerjaanController@store');
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
