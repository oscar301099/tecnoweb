<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\Pedido;
use App\Models\Promocion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //return "asd";
        $supervision = Promocion::all();
        
        //return view('admin.supervision.dashboard', compact('supervision'));
        return view('admin.supervision.index', compact('supervision'));
    }
    
    public function mostrarGraficos()
    {
        $datosVentas = Pedido::pluck('total'); // Suponiendo que 'monto' es el campo que quieres para las ventas.

        return view('admin.supervision.index', compact('datosVentas'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.supervision.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'porcentaje' => 'required|numeric|between:0,99.99'
        ]);
        $promocion = Promocion::Create([
            'nombre' => $request->nombre,
            'porcentaje' => $request->porcentaje,
        ]);

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Promoción';
        $afectado = $promocion->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.supervision.index')->with('info', 'La Promocion se ha registrado correctamente');

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
    public function edit($id)
    {
        $promocion = Promocion::find($id);
        return view('admin.supervision.edit', compact('promocion'));
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
            'porcentaje' => 'required|numeric|between:0,99.99'
        ]);
        $promocion = Promocion::find($id);
        $promocion->nombre = $request->nombre;
        $promocion->porcentaje = $request->porcentaje;
        $promocion->save();
        
        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Promoción';
        $afectado = $promocion->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.supervision.edit', $promocion)->with('info', 'los datos se editaron correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $promocion = Promocion::find($id);
        $promocion->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Promoción';
        $afectado = $promocion->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info','La Promocion ha sido eliminado correctamente');
    }
}
