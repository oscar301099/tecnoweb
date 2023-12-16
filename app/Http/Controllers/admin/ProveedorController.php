<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\detalle_productos;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $proveedores = Proveedor::all();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.proveedores.create');
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
            'direccion' => 'required',
            'telefono' => 'required',
        ]);
        $proveedor = Proveedor::Create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Proveedor';
        $afectado = $proveedor->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.proveedores.index')->with('info', 'El Proveedor se ha registrado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        
        $detalles = detalle_productos::where('proveedor_id',$id)->get();
        $proveedor = Proveedor::find($id);
        $producto = Producto::all();
        return view('admin.proveedores.show',compact('detalles', 'proveedor', 'producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $proveedor = Proveedor::find($id)->first();
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
        ]);
        $proveedor = Proveedor::find($id)->first();
        $proveedor->nombre = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->save();

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Proveedor';
        $afectado = $proveedor->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.proveedores.edit', $proveedor)->with('info', 'los datos se editaron correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        $proveedor = Proveedor::find($id);
        $proveedor->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Proveedor';
        $afectado = $proveedor->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info','El Proveedor ha sido eliminado correctamente');
    }
}
