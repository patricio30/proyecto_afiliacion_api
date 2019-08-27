<?php

use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

//rutas para titulares
Route::get('api/api_afiliacion/titulares', 'TitularController@getTitulares');
Route::get('api/api_afiliacion/titular/{id_titular}', 'TitularController@getTitular');
Route::post('api/api_afiliacion/titular', 'TitularController@addTitular');
Route::get('api/api_afiliacion/cargas_titular/{id_titular}', 'TitularController@getCargas');
Route::post('api/api_afiliacion/editar_titular', 'TitularController@editarTitular');


//rutas para cargas
Route::get('api/api_afiliacion/cargas', 'CargaController@getCargas');
Route::get('api/api_afiliacion/carga/{id_carga}', 'CargaController@getCarga');
Route::post('api/api_afiliacion/carga', 'CargaController@addCarga');
Route::get('api/api_afiliacion/titular_carga/{id_carga}', 'CargaController@getTitular');
Route::post('api/api_afiliacion/editar_carga', 'CargaController@editarCarga');