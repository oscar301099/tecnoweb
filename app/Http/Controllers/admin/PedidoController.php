<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\Categoria;
use App\Models\Configuration;
use App\Models\detalle_pedido;
use App\Models\Factura;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\Tipo_envio;
use App\Models\Tipo_pago;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::all();
        
        $clientes = User::all();
        return view('admin.pedidos.index', compact('pedidos', 'clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipopagos = Tipo_pago::all();
        $tipoenvios = Tipo_envio::all();
        $promociones = Promocion::all();
        $clientes = User::all();
        return view('admin.pedidos.create', compact('tipopagos', 'tipoenvios', 'promociones', 'clientes'));
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
            'direccion' => 'required',
            'tipoEnvio_id' => 'required',
            'tipoPago_id' => 'required',
            'cliente_id' => 'required',
        ]);
        $pedido = new Pedido();
        $pedido->direccion = $request->direccion;
        $pedido->tipoEnvio_id = $request->tipoEnvio_id;
        $pedido->tipoPago_id = $request->tipoPago_id;
        $pedido->promocion_id = $request->promocion_id;
        $pedido->cliente_id = $request->cliente_id;
        $pedido->fecha_pedido = now();
        $pedido->estado = 'En espera';
        $pedido->estado_pago = 'Impagado';
        $pedido->total = 0;
        $pedido->save();

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Pedido';
        $afectado = $pedido->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.pedidos.index')->with('info', 'El Pedido se ha registrado correctamente');
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
        $pedido = Pedido::where('id', $id)->first();
        $tipopagos = Tipo_pago::all();
        $tipoenvios = Tipo_envio::all();
        $promociones = Promocion::all();
        $clientes = User::all();
        return view('admin.pedidos.edit', compact('tipopagos', 'tipoenvios', 'promociones', 'clientes', 'pedido'));
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
        $request->validate([
            'direccion' => 'required',
            'tipoEnvio_id' => 'required',
            'tipoPago_id' => 'required',
            'cliente_id' => 'required',
        ]);

        $pedido = Pedido::where('id', $id)->first();
        $pedido->cliente_id = $request->cliente_id;
        $pedido->direccion = $request->direccion;
        $pedido->tipoEnvio_id = $request->tipoEnvio_id;
        $pedido->tipoPago_id = $request->tipoPago_id;
        $pedido->promocion_id = $request->promocion_id;
        $pedido->save();

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Pedido';
        $afectado = $pedido->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();
        return redirect()->route('admin.pedidos.edit', $pedido)->with('info', 'Los Datos se Editaron correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pedido = Pedido::find($id)->first();
        $pedido->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Pedido';
        $afectado = $pedido->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info', 'El pedido ha sido eliminado correctamente');
    }

    public function entregado(Request $request, $id)
    {
        $pedido = Pedido::find($id);
        $pedido->estado = 'Entregado';
        $pedido->save();

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Pedido';
        $afectado = $pedido->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info', 'Cambio de estado a Entregado');
    }

    public function espera(Request $request, $id)
    {
        $pedido = Pedido::find($id);
        $pedido->estado = 'En espera';
        $pedido->save();

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Pedido';
        $afectado = $pedido->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info', 'Cambio de estado a En Espera');
    }

    public function CreateFactura(Request $request, $id)
    {
        $config = Configuration::find(1);
        $pedido = Pedido::find($id);
        $facts = Factura::all();
        foreach ($facts as $key) {
            if ($key->pedido_id == $pedido->id) {
                return back()->with('info', 'La Factura ya ha sido Creada');
            }
        }

        $factura = new Factura();
        $factura->nit = $config->factura;
        $factura->pago_neto = $pedido->total;
        $factura->pedido_id = $id;
        $verif = $pedido->promocion_id;
        if ($pedido->total == 0) {
            return back()->with('info2', 'No se registraron Productos en el Pedido');
        }
        if (is_null($verif)) {
            $factura->pago_total = $pedido->total;
        } else {
            $promocion = Promocion::where('id', $pedido->promocion_id)->first();
            $vpromo = $pedido->total * ($promocion->porcentaje / 100);
            $factura->pago_total = $pedido->total - $vpromo;
        }
        $factura->save();
        $pedido->estado_pago = 'Pagado';
        $pedido->save();

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Pedido';
        $afectado = $pedido->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Factura';
        $afectado = $factura->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.pedidos.index')->with('info', 'Factura registrada y Pago cancelado');
    }

    public function DestroyFactura(Request $request, $id)
    {

        $pedido = Pedido::find($id);
        $factura = Factura::where('pedido_id', $pedido->id)->first();
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

        return back()->with('info', 'Factura: ' . $factura->id . 'del Pedido: ' . $pedido->id . ' del Cliente: ' . $cliente->name . ' se ha eliminado correctamente');
    }
}