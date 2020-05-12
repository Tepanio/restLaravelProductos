<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Usuario;
use App\Producto;
use App\Pedido;

class UsuarioController extends Controller
{
    

    public function get(){
        $usuario = Usuario::with('pedidos.productos')->get();
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

    public function getPedidos($id){

        $pedidos = Pedido::with('productos')->where('usuario_id','=',$id)->get()
            ->each(function($pedido){
                $pedido->productos->map(function($producto){
                $producto->cantidad = $producto->pivot->cantidad;
                unset($producto->pivot);
                return $producto;
            });

        });
        
        return response()->json($pedidos,201);
    }


}
