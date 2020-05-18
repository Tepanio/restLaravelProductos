<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;
use App\Producto;
use App\Pedido;
use App\Factura;

class UsuarioController extends Controller
{


    public function get($id){

        Usuario::findOrFail($id);
        $usuario = Usuario::with('pedidos.factura')->where('username','=',$id)->firstOrFail();
        return response()->json($usuario,200);
    }

    public function getAll(){

        $usuario = Usuario::with('pedidos.factura')->get();
        return response()->json($usuario,200);
    }

    public function new(Request $request){
        $usuario_data = json_decode($request->getContent(),true);
        $usuario_data['password'] = Hash::make($usuario_data['password']);
        $usuario =Usuario::create($usuario_data);
        return response()->json($usuario,201);
    }

    public function edit(Request $request, $id){
        $usuario = Usuario::findOrFail($id);
        $usuario->update(json_decode($request->getContent(), true));
        return response()->json($usuario, 200);
    }

    public function delete($id){
        $usuario = Usuario::find($id);
        $usuario->delete();
        return response()->json(null,204);
    }


    public function getCarrito($id,Request $request){
        $data = json_decode($request->getContent(), true);
        $usuario = Usuario::findOrFail($id);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->first();
        if(is_null($pedido)){
            $pedido = new Pedido;
            $pedido->estado= 'carrito';
            $usuario->pedidos()->save($pedido);
            $pedido->save();
        }
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }

        return response()->json($productos,201);
    }

    public function postCarrito($id,Request $request){
        $data = json_decode($request->getContent(), true);
        $usuario = Usuario::findOrFail($id);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        $pedido->productos()->attach($data);
        $pedido->save();
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }

    public function putCarrito($id,Request $request){
        $data = json_decode($request->getContent(), true);
        $usuario = Usuario::findOrFail($id);
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


    public function deleteCarrito($id,Request $request){

        $usuario = Usuario::findOrFail($id);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        $pedido->productos()->detach($request->get('producto_id'));
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }


    public function pagarCarrito($id){
        $usuario = Usuario::findOrFail($id);
        $pedido1 = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        //$pedido1->update(['estado' => "pago"]);
        $factura =  new Factura;
        $costo = 0;
        foreach ($pedido1->productos()->get() as $producto) {
            $cantidad = $producto->pivot->cantidad;
            $costo = $costo + ($cantidad * $producto->precio);

        }
        $factura->total = $costo;
        $pedido1->factura()->save($factura);
      //  $pedido = new Pedido;
       // $pedido->estado= 'carrito';
       // $usuario->pedidos()->save($pedido);
       // $pedido->save();
        return response()->json([],201);
    }




}
