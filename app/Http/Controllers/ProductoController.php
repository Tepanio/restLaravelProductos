<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
class ProductoController extends Controller
{
    public function get(){
        $producto = Producto::get();
        return response()->json($producto,200);
    }

    public function new(Request $request){
        $producto =Producto::create(json_decode($request->getContent(), true));
        return response()->json($producto,201);
    }

    public function edit(Request $request, $id){
        $producto = Producto::findOrFail($id);
        $producto->update(json_decode($request->getContent(), true));
        return response()->json($producto, 200);
    }

    public function delete($id){
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(null,204);
    }
}
