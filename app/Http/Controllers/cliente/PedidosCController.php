<?php

namespace App\Http\Controllers\cliente;

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

class PedidosCController extends Controller
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
        return view('cliente.Pedidos.index', compact('pedidos', 'clientes'));
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
        $clientes = Auth::user();
        return view('cliente.Pedidos.create', compact('tipopagos', 'tipoenvios', 'promociones', 'clientes'));
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
            'tipoEnvio_id' => 'required',
            'tipoPago_id' => 'required',
            'cliente_id' => 'required',
        ]);
        $pedido = New Pedido();
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

        return redirect()->route('cliente.pedidos.index')->with('info', 'El Pedido se ha registrado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalles = detalle_pedido::where('pedido_id', $id)->get();
        $pedido = Pedido::where('id', $id)->first();
        $cliente = User::where('id', $pedido->cliente_id)->first();
        $productos = Producto::all();

        $tipopagos = Tipo_pago::all();
        $tipoenvios = Tipo_envio::all();
        $promociones = Promocion::all();
        $clientes = User::all();
        return view('cliente.Pedidos.detalle', compact('detalles', 'cliente', 'pedido', 'productos','tipopagos', 'tipoenvios', 'promociones', 'clientes'));
 
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

        return back()->with('info','El pedido ha sido eliminado correctamente');
    }

    public function indexP($id)
    {
        $pedido = Pedido::where('id', $id)->first();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        //$productos = Producto::paginate(3);
        return view('cliente.productos', compact('categorias','marcas','pedido'));
    }

    public function storeP(Request $request, $idproducto){
        $request->validate([
            //'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
        ]);
        $pedido = Pedido::where('id',$request->idpedido)->first();
        $producto = Producto::find($idproducto); 
        $detalle = new detalle_pedido();
        $detalle->producto_id = $idproducto;
        $detalle->pedido_id = $request->idpedido;
        $detalle->cantidad = $request->cantidad;
        //si la cantidad es mayor al stock
        if($detalle->cantidad > $producto->stock){
            return redirect()->route('cliente.pedidos.indexP', $pedido->id)->with('info2', 'No hay suficiente Stock de: '. $producto->nombre);
        }
        //calcula el precio
        $detalle->precio = $request->cantidad * $producto->precio;
        //descuenta stock de productos
        $producto->stock = $producto->stock - $detalle->cantidad;
        $producto->save();
        $detalle->save();
        //Pedido Total
        $pedido->total = $pedido->total + $detalle->precio;
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
        
        return redirect()->route('cliente.pedidos.indexP', $pedido->id)->with('info', 'Producto Agregado correctamente');

    }

    public function DetalleDestroy(Request $request, $id){
        $detalle = detalle_pedido::find($id);
        $pedido = Pedido::where('id',$detalle->pedido_id)->first();
        $producto = Producto::where('id', $detalle->producto_id)->first();
        // el producto vuelve a subir
        $producto->stock = $producto->stock + $detalle->cantidad;
        //el total del pedido baja
        $pedido->total = $pedido->total - $detalle->precio;
        $producto->save();
        $pedido->save();
        $detalle->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Detalle_Pedido';
        $afectado = $detalle->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();


        return back()->with('info','El detalle se ha eliminado correctamente');
    }

    public function CreateFactura(Request $request, $id){
        $config = Configuration::find(1);
        $pedido = Pedido::find($id);
        $facts = Factura::all();
        foreach ($facts as $key) {
            if($key->pedido_id == $pedido->id){
                return back()->with('info','La Factura ya ha sido Creada');
            }
        }
    
        $factura = new Factura();
        $factura->nit = $config->factura;
        $factura->pago_neto = $pedido->total;
        $factura->pedido_id = $id;
        $verif = $pedido->promocion_id;
        if($pedido->total == 0){
            return back()->with('info2','No se registraron Productos en el Pedido');
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

        return redirect()->route('cliente.pedidos.index')->with('info', 'Factura registrada y Pago cancelado');

    }

}