<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Usuario;
use App\Producto;
use App\Pedido;

class UsuarioController extends Controller
{
    

    public function get($id){

        Usuario::findOrFail($id);
        $usuario = Usuario::with('pedidos.factura')->where('id','=',$id)->get();

        return response()->json($usuario,200);
    }

    public function getAll($id){

        $usuario = Usuario::with('pedidos.factura')->get();
        return response()->json($usuario,200);
    }

    public function new(Request $request){
        $usuario =Usuario::create(json_decode($request->getContent(), true));     
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


}
