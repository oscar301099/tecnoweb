<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\Configuration;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\Promocion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $facturas = Factura::all();
        $pedidos = Pedido::all();
        $clientes = User::all();
        return view('admin.facturas.index', compact('facturas', 'pedidos', 'clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pedidos = Pedido::all();
        $clientes = User::all();
        return view('admin.facturas.create', compact('pedidos', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'pedido_id' => 'required'
        ]);

        $config = Configuration::find(1);
        $pedido = Pedido::find($request->pedido_id);
        $facts = Factura::all();
        
        foreach ($facts as $key) {
            if($key->pedido_id == $pedido->id){
                return back()->with('info','La Factura ya ha sido Creada');
            }
        }
    
        $factura = new Factura();
        $factura->nit = $config->factura;
        $factura->pago_neto = $pedido->total;
        $factura->pedido_id = $request->pedido_id;
        $verif = $pedido->promocion_id;
        if($pedido->total == 0){
            return back()->with('info','No se registraron Productos en el Pedido');
        }
        if (is_null($verif)) {
            $factura->pago_total = $pedido->total;
        }else{
            $promocion = Promocion::where('id', $pedido->promocion_id)->first();
            $vpromo = $pedido->total * ($promocion->porcentaje / 100);
            $factura->pago_total = $pedido->total - $vpromo;
        }
        $factura->save();
        $pedido->estado_pago = 'Pagado';
        $pedido->save();

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Factura';
        $afectado = $factura->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.facturas.index')->with('info', 'Factura Registrada');

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        
        $factura = Factura::find($id);
        $pedido = Pedido::where('id', $factura->pedido_id)->first();
        $cliente = User::where('id', $pedido->cliente_id)->first();
        $pedido->estado_pago = 'Impagado';
        $pedido->save();
        $factura->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Factura';
        $afectado = $factura->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info','Factura: '. $factura->id .' del Pedido: '.$pedido->id.' del Cliente: '.$cliente->name.' se ha eliminado correctamente');
  
    }
}
