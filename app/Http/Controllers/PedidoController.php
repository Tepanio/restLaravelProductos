<?php

namespace App\Http\Controllers;
use App\Usuario;
use App\Producto;
use App\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function new(Request $request){
        $data = json_decode($request->getContent(), true);
        $usuario = Usuario::find($data["user_id"]);
        $pedido = new Pedido;
        $pedido->timestamps = false;
        $usuario->timestamps = false;
        $usuario->pedidos()->save($pedido);
        $pedido->productos()->attach($data["productos"]);
        $pedido->save();
        return response()->json($pedido->productos()->get(),201);
    }
    

    public function edit(Request $request, $id){
        $data = json_decode($request->getContent(), true);
        $pedido = Pedido::find($id);
        $pedido->timestamps = false;
        $pedido->productos()->detach();
        $pedido->productos()->attach($data["productos"]);
        $pedido->save();
        return response()->json($pedido->productos()->get(),201);
    }

    public function delete($id){
        $pedido = Pedido::find($id);
        $pedido->delete();
        return response()->json(null,204);
    }
}
