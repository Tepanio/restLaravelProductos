<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Usuario Route
Route::get('usuarios/{id}','UsuarioController@get');
Route::get('usuarios/','UsuarioController@getAll');
Route::post('usuarios','UsuarioController@new');
Route::put('usuarios/{id}','UsuarioController@edit');
Route::delete('usuarios/{id}','UsuarioController@delete');

///Pedid\Route::get('carrito','PedidoController@getCarrito');
Route::put('carrito','PedidoController@edit');

Route::get('pedidos/{id}','PedidoController@getById');
Route::get('pedidos','PedidoController@get');
Route::delete('pedidos/{id}','PedidoController@delete');

///Articulo
Route::get('producto','ProductoController@get');
Route::post('producto','ProductoController@new');
Route::put('producto/{id}','ProductoController@edit');
Route::delete('producto/{id}','ProductoController@delete');
