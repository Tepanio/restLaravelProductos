<?php

namespace App\Http\Controllers;
use App\Usuario;
use App\Producto;
use App\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller

{
    public function get($id){

        $pedidos = Pedido::with('productos','factura')->where('id','=',$id)->get()
            ->each(function($pedido){
                $pedido->productos->map(function($producto){
                $producto->cantidad = $producto->pivot->cantidad;
                unset($producto->pivot);
                return $producto;
            });

        });
        
        return response()->json($pedidos,201);
    }


    public function edit(Request $request){
        $data = json_decode($request->getContent(), true);
        $usuario = Usuario::find($data["user_id"]);
        $pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        $pedido->productos()->detach();
        $pedido->save();
        
        $pedido->productos()->attach($data['productos']);
        
        $pedido->save();
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }


    public function getCarrito(Request $request){
        $data = json_decode($request->getContent(), true);
        $usuario = Usuario::find($data["user_id"]);
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

    public function getPago(){

        $pedidos = Pedido::with('productos')->where('estado','=','pago')->get()
            ->each(function($pedido){
                $pedido->productos->map(function($producto){
                $producto->cantidad = $producto->pivot->cantidad;
                unset($producto->pivot);
                return $producto;
            });

        });
        
        return response()->json($pedidos,201);
    }
    public function getEntregado(){

        $pedidos = Pedido::with('productos')->where('estado','=','entregado')->get()
            ->each(function($pedido){
                $pedido->productos->map(function($producto){
                $producto->cantidad = $producto->pivot->cantidad;
                unset($producto->pivot);
                return $producto;
            });

        });
        
        return response()->json($pedidos,201);
    }
    public function delete($id){
        $pedido = Pedido::find($id);
        $pedido->delete();
        return response()->json(null,204);
    }
}
