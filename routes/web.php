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
    return view('welcome');
});
// Route::get('juego', function(){
// 	return view('juego_bons');
// });


Route::get('juego', 'JuegoController@index');
Route::post('juego', 'JuegoController@crearJuego');
Route::post('jugada', 'JuegoController@Jugada');
