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

Route::post('crear', 'UsuarioController@crearUsuario')->name('usuario.crear');
Route::post('actualizar', 'UsuarioController@actualizarUsuario')->name('usuario.actualizar');
Route::get('listar', 'UsuarioController@listarUsuario')->name('usuario.listar');
Route::get('buscar/{id}', 'UsuarioController@buscarUsuario')->name('usuario.buscar');
Route::get('test', 'UsuarioController@testDB')->name('DB.test');