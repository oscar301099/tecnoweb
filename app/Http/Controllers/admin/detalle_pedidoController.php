<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\Categoria;
use App\Models\detalle_pedido;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\Tipo_envio;
use App\Models\Tipo_pago;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class detalle_pedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detalles = detalle_pedido::all();
        $productos = Producto::all();
        $pedidos = Pedido::all();
        $clientes = User::all();
        
        return view('admin.detallePedido.indexGeneral', compact('detalles', 'productos', 'pedidos', 'clientes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
        return view('admin.detallePedido.index', compact('detalles', 'cliente', 'pedido', 'productos','tipopagos', 'tipoenvios', 'promociones', 'clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
      $detalle = detalle_pedido::find($id);
      $productos = Producto::all();
      return view('admin.detallePedido.edit', compact('detalle', 'productos'));
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
            'cantidad' => 'required|integer',
        ]);
        $detalle = detalle_pedido::find($id);
        $pedido = Pedido::where('id', $detalle->pedido_id)->first();
        $producto = Producto::where('id', $detalle->producto_id)->first();

        if($request->cantidad > $producto->stock){
            return back()->with('info2', 'No hay suficiente Stock de: '. $producto->nombre);
        }
        //actualizo el producto
        $producto->stock = $producto->stock + $detalle->cantidad; //devolvemos la cantidad
        $producto->stock = $producto->stock - $request->cantidad; //actualizamos el stock

        //actualizar el precio del pedido
        $precio = $request->cantidad * $producto->precio; //nuevo precio del detalle
        $pedido->total = $pedido->total - $detalle->precio;
        $pedido->total = $pedido->total + $precio;

        //actualizar detalle
        $detalle->cantidad = $request->cantidad;
        $detalle->precio = $precio;

        $producto->save();
        $pedido->save();
        $detalle->save();


        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Detalle_Pedido';
        $afectado = $detalle->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.detalle_pedidos.show', $pedido->id)->with('info', 'Los datos se actualizaron correctamente');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
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

    public function indexP($id)
    {
        $pedido = Pedido::where('id', $id)->first();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $productos = Producto::all();
        return view('admin.detallePedido.productos', compact('productos','categorias','marcas','pedido'));
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
            return redirect()->route('admin.detalle_pedidos.indexP', $pedido->id)->with('info2', 'No hay suficiente Stock de: '. $producto->nombre);
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
        
        return redirect()->route('admin.detalle_pedidos.indexP', $pedido->id)->with('info', 'Producto Agregado correctamente');

    }

    public function editGeneral($id){
        $detalle = detalle_pedido::find($id);
        $productos = Producto::all();
        return view('admin.detallePedido.editarGeneral', compact('detalle', 'productos'));
      }
}
