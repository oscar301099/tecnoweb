<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\detalle_productos;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos', 'categorias', 'marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $categoria = categoria::all();
        $marca = Marca::all();
        return view('admin.productos.create', compact('categoria','marca'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required',
            'marca_id' => 'required',
            'imagen' => 'required'
        ]);


        $producto = Producto::Create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id,
            'precio' => $request->precio,
            'stock' => $request->stock,         
            'imagen' => $request->imagen
        ]);

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Producto';
        $afectado = $producto->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.productos.index')->with('info', 'El Producto se ha registrado correctamente');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto){
        $categorias = categoria::all();
        $marcas = Marca::all();
        return view('admin.productos.show', compact('producto','categorias','marcas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto){

        $categoria = categoria::all();
        $marca = Marca::all();
        return view('admin.productos.edit', compact('producto','categoria','marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto){
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'required'
        ]);

        $data = $request->only('id','nombre', 'descripcion', 'precio', 'stock');

        if (trim($request->imagen == '')) {
            $data = $request->except('imagen');

                if ($request->categoria_id == '') {
                    $data = $request->except('categoria_id');
                }

                if ($request->marca_id == '') {
                    $data = $request->except('marca_id');
                }
        }else{
            $data = $request->all();
            $data['imagen'] = $request->imagen;
        }

        $producto->update($data);

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Producto';
        $afectado = $producto->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();
        
        return redirect()->route('admin.productos.edit', $producto)->with('info', 'Se editaron los datos correctamente');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Producto $producto){
        $producto->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Producto';
        $afectado = $producto->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info','El Producto ha sido eliminado correctamente');
    }


    
    public function reporte(){
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $productos = Producto::all();
        $detalle = detalle_productos::all();
        return view('admin.productos.reporte', compact('productos', 'categorias', 'marcas', 'detalle'));
    }
}
