<?php

namespace App\Http\Controllers\ListaDeCompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ListaDeCompra;
use App\Articulo;

class ListaDeCompraController extends Controller
{
    public function listadecompra(){
        $lista = ListaDeCompra::get();

        return response()->json($lista,200);
    }

    public function listadecomprart(){
        $lista = ListaDeCompra::with('articulos')->get();

        return response()->json($lista,200);
    }

    public function listadecompraById($id){
    
        $lista = ListaDeCompra::with('articulos')->find($id);

        return response()->json($lista,200);

    }

    // A mano
    public function newlistadecompra(Request $request){
        $country = new ListaDeCompra;
        $country->name = $request->input('name');
        $country->id = $request->input('id');
        $country -> save();
        //$country = json_decode($request->getContent());
        return response()->json($country,201);
    }

    public function newjson(Request $request){
        $country =ListaDeCompra::create(json_decode($request->getContent(), true));
        //$country = json_decode($request->getContent());
        return response()->json($country,201);
    }

    public function editlistacompra(Request $request, $id){
        $lista = ListaDeCompra::find($id);
        $lista->update(json_decode($request->getContent(), true));
        return response()->json($lista, 200);
    }

    public function deletelistacompra($id){
        $list = ListaDeCompra::find($id);
        $list->delete();
        return response()->json(null,204);
    }

}
