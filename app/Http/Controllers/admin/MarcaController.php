<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $marcas = Marca::all();
        return view('admin.marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.marcas.create');
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
        ]);
        $marca = Marca::Create([
            'nombre' => $request->nombre,
        ]);

        
        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Marca';
        $afectado = $marca->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.marcas.index')->with('info', 'La Marca se ha registrado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca){
        return view('admin.marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca){
        $request->validate([
            'nombre' => 'required',
        ]);

        $marca->update($request->all());

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Marca';
        $afectado = $marca->id;
        $bita->afectado = ($afectado);
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.marcas.edit', $marca)->with('info', 'Los Datos se Editaron correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Marca $marca){
        $marca->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Marca';
        $afectado = $marca->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info','La Marca ha sido eliminada correctamente');
    }
}
