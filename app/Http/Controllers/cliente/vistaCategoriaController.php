<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\ContadorPage;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class vistaCategoriaController extends Controller{
    
    public function index($id){
        $categoria = Categoria::where('id',$id)->first();
        $nombrepagina=$categoria->nombre;
        DB::beginTransaction();
        $cantidad= ContadorPage::SumarContador($nombrepagina);
      
        DB::commit();

        $productos = Producto::where('categoria_id',$id)->paginate(3);
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('cliente.index', compact('productos', 'marcas', 'categorias','cantidad'));
    }

    public function perfil(){
        $cliente = Auth::user();
        return view('cliente.perfil', compact('cliente'));
    }

    public function EditPerfil(){
        $cliente = Auth::user();
        return view('cliente.editperfil', compact('cliente'));
    }

    
}
