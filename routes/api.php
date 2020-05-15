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

Route::get('usuarios/{id}/carrito','UsuarioController@getCarrito');
Route::post('usuarios/{id}/carrito','UsuarioController@postCarrito');
Route::put('usuarios/{id}/carrito','UsuarioController@putCarrito');
Route::delete('usuarios/{id}/carrito','UsuarioController@deleteCarrito');

///Pedidos
//Route::get('carrito','PedidoController@getCarrito');
//Route::put('carrito','PedidoController@edit');

Route::get('pedidos/{id}','PedidoController@getById');
Route::put('pedidos/{id}','PedidoController@putProducto');
Route::post('pedidos/{id}','PedidoController@postProducto');
Route::delete('pedidos/{id}','PedidoController@deleteProducto');


Route::get('pedidos','PedidoController@get');
Route::delete('pedidos/{id}','PedidoController@delete');

///Articulo
Route::get('productos','ProductoController@get');
Route::post('productos','ProductoController@new');
Route::put('productos/{id}','ProductoController@edit');
Route::delete('productos/{id}','ProductoController@delete');
