<?php

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
    return view('contenido/contenido');
});

Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');
Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');


Route::get('/pilar', 'PilarController@index');
Route::post('/pilar/registrar', 'PilarController@store');
Route::put('/pilar/actualizar', 'PilarController@update');
Route::put('/pilar/desactivar', 'PilarController@desactivar');
Route::put('/pilar/activar', 'PilarController@activar');
Route::get('/pilar/selectPilar', 'PilarController@selectPilar');

Route::get('/indicador', 'IndicadorController@index');
Route::post('/indicador/registrar', 'IndicadorController@store');
Route::put('/indicador/actualizar', 'IndicadorController@update');
Route::put('/indicador/desactivar', 'IndicadorController@desactivar');
Route::put('/indicador/activar', 'IndicadorController@activar');
Route::get('/indicador/buscarArticulo', 'IndicadorController@buscarIndicador');
Route::get('/indicador/listarArticulo', 'IndicadorController@listarIndicador');
Route::get('/indicador/listarPdf','IndicadorController@listarPdf')->name('indicador_pdf');
Route::get('/indicador/selectIndicador', 'IndicadorController@selectIndicador');

Route::get('/pregunta', 'PreguntaController@index');
Route::post('/pregunta/registrar', 'PreguntaController@store');
Route::put('/pregunta/actualizar', 'PreguntaController@update');
Route::put('/pregunta/desactivar', 'PreguntaController@desactivar');
Route::put('/pregunta/activar', 'PreguntaController@activar');
