<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class vistaCategoriaController extends Controller{
    
    public function index($id){
        $productos = Producto::where('categoria_id',$id)->paginate(3);
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('cliente.index', compact('productos', 'marcas', 'categorias'));
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
