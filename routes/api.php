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
Route::get('usuario','UsuarioController@get');
Route::post('usuario','UsuarioController@new');
Route::put('usuario/{id}','UsuarioController@edit');
Route::delete('usuario/{id}','UsuarioController@delete');
///Pedido
Route::post('pedido','PedidoController@new');
//Route::put('pedido/{id}','PedidoController@editAdd');
Route::put('pedido/{id}','PedidoController@edit');
Route::delete('pedido/{id}','PedidoController@delete');


Route::get('listadecompra','ListaDeCompra\ListaDeCompraController@listadecompra');
Route::get('listadecomprart','ListaDeCompra\ListaDeCompraController@listadecomprart');
Route::get('listadecompra/{id}','ListaDeCompra\ListaDeCompraController@listadecompraById');
Route::post('listadecompra','ListaDeCompra\ListaDeCompraController@newlistadecompra');
Route::post('listajson','ListaDeCompra\ListaDeCompraController@newjson');
Route::put('listadecompra/{id}','ListaDeCompra\ListaDeCompraController@editlistacompra');
Route::delete('listadecompra/{id}','ListaDeCompra\ListaDeCompraController@deletelistacompra');

