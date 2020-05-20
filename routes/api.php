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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Usuario Route
Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');
});


//Las rutas que esten definidas en este callback requieren que un usuario este logueado,
//todavia no se controla la confirmacion del mail.
Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::get('usuarios/{id}','UsuarioController@get');
    Route::get('usuarios','UsuarioController@getAll');
    Route::post('usuarios','UsuarioController@new');
    Route::put('usuarios/{id}','UsuarioController@edit');
    Route::delete('usuarios/{id}','UsuarioController@delete');

    Route::get('usuarios/{id}/carrito','UsuarioController@getCarrito');
    Route::post('usuarios/{id}/carrito','UsuarioController@postCarrito');
    Route::put('usuarios/{id}/carrito','UsuarioController@putCarrito');
    Route::delete('usuarios/{id}/carrito/$producto_id','UsuarioController@deleteCarrito');
    Route::put('usuarios/{id}/carrito/pagar','UsuarioController@pagarCarrito');


    ///Pedidos
    //Route::get('carrito','PedidoController@getCarrito');
    //Route::put('carrito','PedidoController@edit');
    
    Route::get('pedidos','PedidoController@get');
    Route::get('pedidos/{id}','PedidoController@getById');
    Route::put('pedidos/{id}','PedidoController@changeState');
    Route::delete('pedidos/{id}','PedidoController@delete');


    Route::put('pedidos/{id}/productos/{id_producto}','PedidoController@putProducto');
    Route::post('pedidos/{id}/productos','PedidoController@postProducto');
    Route::delete('pedidos/{id}/productos/{id_producto}','PedidoController@deleteProducto');


    

    ///Articulo
    Route::get('productos','ProductoController@get');
    Route::post('productos','ProductoController@new');
    Route::put('productos/{id}','ProductoController@edit');
    Route::delete('productos/{id}','ProductoController@delete');
});
