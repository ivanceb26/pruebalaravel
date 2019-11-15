<?php

use Illuminate\Http\Request;

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

Route::post('crear', 'UsuarioController@crearUsuario')->name('usuario.crear');
Route::post('actualizar', 'UsuarioController@actualizarUsuario')->name('usuario.actualizar');
Route::get('listar', 'UsuarioController@listarUsuario')->name('usuario.listar');
Route::get('test', 'UsuarioController@testDB')->name('DB.test');
Route::get('buscar/{id}', 'UsuarioController@buscarUsuario')->name('usuario.buscar');