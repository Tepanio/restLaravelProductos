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


Route::group([
    'middleware' => ['auth:api', 'verified'],
], function ($router) {
    Route::get('usuarios/{id}','UsuarioController@get'); //Condicional: usuario puede pedir sus datos
    Route::get('usuarios','UsuarioController@getAll')->middleware('admin');
    Route::put('usuarios/{id}','UsuarioController@edit'); //Condicional: usuario puede modificarse a si mismo
    Route::delete('usuarios/{id}','UsuarioController@delete'); //Condicional: usuario puede borrarse a si mismo

    Route::get('usuarios/{id}/carrito','UsuarioController@getCarrito'); //Condicional: usuario puede pedir sus datos
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

Route::post('usuarios','UsuarioController@new');

Route::get('usuarios/{username}/verification/resend', 'VerificationController@resend')->name('verification.resend');
Route::get('usuarios/{username}/verification/{hash}', 'VerificationController@verify')->name('verification.verify');

Route::get('usuarios/{username}/password/email', 'PasswordResetController@sendResetLinkEmail');
Route::post('usuarios/password/reset', 'PasswordResetController@reset')->name('password.update');
Route::get('usuarios/password/{username}/reset/{token}')->name('password.reset');
