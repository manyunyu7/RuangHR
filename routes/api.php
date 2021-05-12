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
Route::any('/token/fetch', 'ApiTokenController@fetchToken');

Route::middleware(['token_ruang_hr'])->group(function () {

    //24 Divisi
    Route::any('/divisi/fetch', 'DivisiController@fetch');
    Route::any('/divisi/{id}/detail', 'DivisiController@fetchByID');
    Route::post('/divisi/store', 'DivisiController@storeDivisi');
    Route::put('/divisi/{id}/update', 'DivisiController@update');
    Route::delete('/divisi/{id}/delete', 'DivisiController@delete');



    //33 Pekerjaan
    Route::post('/pekerjaan/store', 'PekerjaanController@store');
    







    //43 Karyawan












    //56 Perizinan
    Route::post('/perizinan/store', 'PerizinanController@store');
    Route::get('/perizinan','PerizinanController@index');
    Route::get('/perizinan/{id}/detail','PerizinanController@show');
    Route::delete('/perizinan/{id}/delete','PerizinanController@destroy');
    Route::post('/perizinan/{id}/update','PerizinanController@update');
    Route::get('/perizinan/fetch', 'PerizinanController@fetchAll');



    
    //68 kehadiran











    //80 Report








    //dll









});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
