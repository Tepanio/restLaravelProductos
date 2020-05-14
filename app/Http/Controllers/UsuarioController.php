<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Usuario;
use App\Producto;
use App\Pedido;

class UsuarioController extends Controller
{
    

    public function get($id){
        if(!is_null($id)){
        $usuario = Usuario::with('pedidos.factura')->where('id','=',$id)->get();
        }
        else{
            $usuario = Usuario::with('pedidos.factura')->get();
        }
        if(empty($usuario)){
            return response()->json($usuario,404);
        }

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



}
