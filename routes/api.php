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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Usuario Route
Route::get('usuario/{id}','UsuarioController@get');
Route::get('usuario/','UsuarioController@getAll');
Route::post('usuario','UsuarioController@new');
Route::put('usuario/{id}','UsuarioController@edit');
Route::delete('usuario/{id}','UsuarioController@delete');

///Pedido
Route::get('carrito','PedidoController@getCarrito');
Route::put('carrito','PedidoController@edit');

Route::get('pedido/{id}','PedidoController@getById');
Route::get('pedido','PedidoController@get');
Route::delete('pedido/{id}','PedidoController@delete');

///Articulo
Route::get('producto','ProductoController@get');
Route::post('producto','ProductoController@new');
Route::put('producto/{id}','ProductoController@edit');
Route::delete('producto/{id}','ProductoController@delete');
