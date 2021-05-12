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
    Route::put('/pekerjaan/{id}/update', 'PekerjaanController@update');
    Route::delete('/pekerjaan/{id}/delete', 'PekerjaanController@delete');
    Route::any('/pekerjaan/fetch', 'PekerjaanController@fetch');
    Route::any('/pekerjaan/{id}/detail', 'PekerjaanController@detail');
    Route::get('/pekerjaan/cari', 'PekerjaanController@cari');



    //43 Karyawan
    Route::post('/pegawai/store', 'PegawaiController@store');
    Route::delete('/pegawai/{id}/delete', 'PegawaiController@delete');
    Route::any('/pegawai/{id}/detail', 'PegawaiController@fetchByID');
    Route::any('/pegawai/fetch', 'PegawaiController@fetchAll');
    Route::post('/pegawai/{id}/update', 'PegawaiController@update');
    Route::get('/pegawai/search', 'PegawaiController@search');






    //56 Perizinan











    //68 kehadiran











    //80 Report








    //dll








    

    //Bonus
    Route::post('/bonus/store', 'BonusController@store');
    Route::delete('/bonus/{id}/delete', 'BonusController@delete');
    Route::any('/bonus/{id}/detail', 'BonusController@fetchByID');
    Route::any('/bonus/fetch', 'BonusController@fetch');
    Route::post('/bonus/{id}/update', 'BonusController@update');
    Route::get('/bonus/cari', 'BonusController@cari');







});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
