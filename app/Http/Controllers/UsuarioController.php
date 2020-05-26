<?php

namespace App\Http\Controllers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;
use App\Producto;
use App\Pedido;
use App\Factura;

class UsuarioController extends Controller
{


    public function get(){
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::with('pedidos.factura')->where('username','=',$username)->firstOrFail();
        return response()->json($usuario,200);
    
    }

    public function getAll(){

        $usuario = Usuario::with('pedidos.factura')->get();
        return response()->json($usuario,200);
    }

    public function new(Request $request){
        $usuario_data = json_decode($request->getContent(),true);
        $usuario_data['password'] = Hash::make($usuario_data['password']);
        $usuario_data['admin'] = false;
        Usuario::create($usuario_data);
        
        $usuario = Usuario::find($usuario_data['username']);

        //event(new Registered($usuario));
        $credentials = $request->only(['username', 'password']);
        if( ! $token = auth()->attempt($credentials)) {
            return response()->json('', 401);
        }
 
        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function edit(Request $request){
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::findOrFail($username);
        $usuario->update(json_decode($request->getContent(), true));
        return response()->json($usuario, 200);
    }

    public function delete(){
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::findOrFail($username);
        $usuario->delete();
        return response()->json(null,204);
    }


    public function getCarrito(Request $request){
        //$data = json_decode($request->getContent(), true);
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::findOrFail($username);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        //if(is_null($pedido)){
        //    $pedido = new Pedido;
        //    $pedido->estado= 'carrito';
        //    $usuario->pedidos()->save($pedido);
        //    $pedido->save();
        //}

        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }

        return response()->json($productos,201);
    }

    public function postCarrito(Request $request){
        $data = json_decode($request->getContent(), true);
        error_log("json\n" . json_encode($request->getContent(), JSON_PRETTY_PRINT));
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::findOrFail($username);
        if ($usuario->pedidos()->where('estado','=','carrito')->exists()){
            $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        }
        else{
            $pedido = new Pedido;
            $usuario->pedidos()->save($pedido);
        }

        $pedido->productos()->attach($data);
        $pedido->save();

        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }

    public function putCarrito(Request $request){
        $data = json_decode($request->getContent(), true);
        
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::findOrFail($username);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        $pedido->productos()->updateExistingPivot($request->get('producto_id'),["cantidad" => $request->get('cantidad')]);

        $pedido->save();
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }


    public function deleteCarrito(Request $request,$producto_id){
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::findOrFail($username);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        $pedido->productos()->detach($producto_id);
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }


    public function pagarCarrito(){
        $username = auth()->user()->username;
        error_log('username:'. $username);
        $usuario = Usuario::findOrFail($username);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        $pedido->update(['estado' => "pendiente"]);
      //  $factura =  new Factura;
      //  $costo = 0;
      //  foreach ($pedido1->productos()->get() as $producto) {
      //      $cantidad = $producto->pivot->cantidad;
      //      $costo = $costo + ($cantidad * $producto->precio);
        //
        //}
        //$factura->total = $costo;
        //$pedido1->factura()->save($factura);
        //  $pedido = new Pedido;
        // $pedido->estado= 'carrito';
        // $usuario->pedidos()->save($pedido);
        // $pedido->save();
        return response()->json($pedido,201);
    }




}
