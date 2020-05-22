<?php

namespace App\Http\Controllers;
use App\Usuario;
use App\Producto;
use App\Pedido;
use App\Factura;
use Illuminate\Http\Request;

class PedidoController extends Controller

{
    public function get(Request $request){
        $usuario_username = $request->get('username');
        $estado = $request->get('estado');
        $comparacion = [];

        if(is_null($usuario_username)){
           array_push($comparacion ,['usuario_username','!=',$usuario_username]);
        }
        else{
            array_push($comparacion ,['usuario_username','=',$usuario_username]);
            array_push($comparacion ,['estado','!=','carrito']);
        }
        if(is_null($estado)){
            array_push($comparacion ,['estado','!=',$estado]);
         }
         else{
             array_push($comparacion ,['estado','=',$estado]);
             array_push($comparacion ,['estado','!=','carrito']);
         }

        $pedidos = Pedido::with('productos','factura')->where($comparacion)->get()
            ->each(function($pedido){
                $pedido->productos->map(function($producto){
                $producto->cantidad = $producto->pivot->cantidad;
                unset($producto->pivot);
                return $producto;
            });

        });

        return response()->json($pedidos,201);
    }


    public function getById($id){
        Pedido::findOrFail($id);
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


    /*
    public function edit(Request $request){
        $data = json_decode($request->getContent(), true);
        $id = $request->get('user_id');
        $usuario = Usuario::findOrFail($id);

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
    */




    public function postProducto($id,Request $request){
        $data = json_decode($request->getContent(), true);
        $pedido = Pedido::findOrFail($id);
        $pedido->productos()->attach($data);
        $pedido->save();
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }

    public function putProducto($id,$id_producto,Request $request){
        $data = json_decode($request->getContent(), true);
        $pedido = Pedido::findOrFail($id);
        $pedido->productos()->updateExistingPivot($id_producto,["cantidad" => $request->get('cantidad')]);
        $pedido->save();
        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }

    public function deleteProducto($id,$id_producto,Request $request){
        $data = json_decode($request->getContent(), true);
        $pedido = Pedido::findOrFail($id);
        $pedido->productos()->detach($id_producto);

        $productos = $pedido->productos()->get();
        foreach ($productos as $producto) {
            $producto->cantidad = $producto->pivot->cantidad;
        unset($producto->pivot);
        }
        return response()->json($productos,201);
    }

    /*
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
*/

    public function delete($id){
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return response()->json(null,204);
    }

    public function changeState($id,Request $request){
        $pedido = Pedido::with("factura")->findOrFail($id);
        $estado = $request->get('estado');

        if($estado === $pedido->estado) {
            return response()->json('',500);
        }

        //$pedido = $usuario->pedidos()->where('estado','=','carrito')->firstOrFail();
        $pedido->update(['estado' => $estado]);
        if(strcmp($estado, 'pago') == 0){
            $factura =  new Factura;
            $costo = 0;
            foreach ($pedido->productos()->get() as $producto) {
                $cantidad = $producto->pivot->cantidad;
                $costo = $costo + ($cantidad * $producto->precio);

            }

            $factura->total = $costo;
            error_log($costo);
            $pedido->factura()->save($factura);

            $user = Usuario::find($pedido->usuario_username);
            $user->sendPaymentReceivedNotification();
        }
        ///$pedido = new Pedido;
        // $pedido->estado= 'carrito';
        // $usuario->pedidos()->save($pedido);
        // $pedido->save();
        $pedido = Pedido::with("factura")->findOrFail($id);
        return response()->json($pedido,201);
    }



}
