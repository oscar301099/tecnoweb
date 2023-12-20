<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\Carrito;
use App\Models\Categoria;
use App\Models\Configuration;
use App\Models\ContadorPage;
use App\Models\Deseo;
use App\Models\detalle_carrito;
use App\Models\detalle_deseo;
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
use Illuminate\Support\Facades\DB;

class PedidosCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::where('cliente_id', Auth::user()->id)->get();
        $nombrepagina = "lista pedidos";
        DB::beginTransaction();
        ContadorPage::SumarContador($nombrepagina);
        DB::commit();
        //$pedidos = Pedido::all();
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
        //return "creatteee";
        $nombrepagina = "crear pedidos";
        DB::beginTransaction();
        ContadorPage::SumarContador($nombrepagina);
        DB::commit();
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

        $clienteId = Auth::id();
        $carrito = Carrito::where('cliente_id', $clienteId)->first();


        $pedido = new Pedido();
        $pedido->direccion = $request->direccion;
        $pedido->tipoEnvio_id = $request->tipoEnvio_id;
        $pedido->tipoPago_id = $request->tipoPago_id;
        $pedido->promocion_id = $request->promocion_id;
        $pedido->cliente_id = $request->cliente_id;
        $pedido->fecha_pedido = now();
        $pedido->estado = 'En espera';
        $pedido->estado_pago = 'Impagado';
        $pedido->total = $carrito->total;
        $pedido->save();

        $productosCarrito = $carrito->productos;

        foreach ($productosCarrito as $producto) {
            $pedido->productos()->attach($producto->id, [
                'cantidad' => $producto->pivot->cantidad,
                'precio' => $producto->pivot->precio,
            ]);
        }

        // Opcional: Eliminar el carrito
        $carrito->total = 0;
        $carrito->productos()->detach(); // Esto eliminará todos los productos asociados al carrito

        $carrito->save();

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
        return view('cliente.Pedidos.detalle', compact('detalles', 'cliente', 'pedido', 'productos', 'tipopagos', 'tipoenvios', 'promociones', 'clientes'));
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

        return back()->with('info', 'El pedido ha sido eliminado correctamente');
    }

    public function indexP($id)
    {
        //return "indexP";
        $pedido = Pedido::where('id', $id)->first();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        //$productos = Producto::paginate(3);
        return view('cliente.productosP', compact('categorias', 'marcas', 'pedido'));
    }


    public function storeP(Request $request, $idproducto)
    {

        //  return "deseo". $idproducto;
        // return "agregar produc";
        $request->validate([
            //'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
        ]);
        $pedido = Pedido::where('id', $request->idpedido)->first();
        $producto = Producto::find($idproducto);
        $detalle = new detalle_pedido();
        $detalle->producto_id = $idproducto;
        $detalle->pedido_id = $request->idpedido;
        $detalle->cantidad = $request->cantidad;
        //si la cantidad es mayor al stock
        if ($detalle->cantidad > $producto->stock) {
            return redirect()->route('cliente.pedidos.indexP', $pedido->id)->with('info2', 'No hay suficiente Stock de: ' . $producto->nombre);
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

    public function DetalleDestroy(Request $request, $id)
    {
        $detalle = detalle_pedido::find($id);
        $pedido = Pedido::where('id', $detalle->pedido_id)->first();
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


        return back()->with('info', 'El detalle se ha eliminado correctamente');
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

        return redirect()->route('cliente.pedidos.index')->with('info', 'Factura registrada y Pago cancelado');
    }



    /*CARRITO */

    public function indexC()
    {
        //return "2";
        //   $pedido = Pedido::where('id', $id)->first();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        //$productos = Producto::paginate(3);
        // return view('cliente.productos', compact('categorias', 'marcas', 'pedido'));
        return view('cliente.productos', compact('categorias', 'marcas'));
    }


    public function storeC(Request $request, $idproducto)
    {
        //Return "asd";
        $request->validate([
            'cantidad' => 'required|integer',
        ]);

        $clienteId = Auth::id();

        $producto = Producto::find($idproducto);
        $carrito = Carrito::where('cliente_id', $clienteId)->first();
        $itemExistente = $carrito->productos()->where('producto_id', $idproducto)->first();

        if ($itemExistente) {
            // Si el producto ya está en el carrito, actualiza la cantidad
            $itemExistente->pivot->cantidad += $request->cantidad;
            $itemExistente->pivot->precio += $request->cantidad * $producto->precio;
            $itemExistente->pivot->save();

            // Verifica si la cantidad es mayor al stock después de actualizar el pivot
            if ($itemExistente->pivot->cantidad > $producto->stock) {
                return redirect()->route('cliente.pedidos.indexC', $carrito->id)->with('info2', 'No hay suficiente Stock de: ' . $producto->nombre);
            }

            // Descuenta el stock de productos
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Actualiza el total del carrito
            $carrito->total += $itemExistente->pivot->precio;
            $carrito->save();
        } else {
            // Si el producto no está en el carrito, agrégalo
            $carrito->productos()->attach($idproducto, ['precio' => $request->cantidad * $producto->precio, 'cantidad' =>  $request->cantidad]);

            // Verifica si la cantidad es mayor al stock después de agregar el producto al carrito
            if ($request->cantidad > $producto->stock) {
                return redirect()->route('cliente.pedidos.indexC', $carrito->id)->with('info2', 'No hay suficiente Stock de: ' . $producto->nombre);
            }

            // Descuenta el stock de productos
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Actualiza el total del carrito
            $carrito->total += $request->cantidad * $producto->precio;
            $carrito->save();
        }

        //  dd($itemExistente->pivot->cantidad . " sssss ". $producto->stock);

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Carrito';
        $afectado = $carrito->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();


        // return redirect()->route('cliente.pedidos.indexP', $pedido->id)->with('info', 'Producto Agregado correctamente');
        return redirect()->route('cliente.pedidos.indexC')->with('info', 'Producto Agregado correctamente');
    }

    public function DetalleDestroyC(Request $request, $id)
    {
        $detalle = detalle_carrito::find($id);
        $carrito = Carrito::where('id', $detalle->carrito_id)->first();
        $producto = Producto::where('id', $detalle->producto_id)->first();
        // el producto vuelve a subir
        $producto->stock = $producto->stock + $detalle->cantidad;
        //el total del carrito baja
        $carrito->total = $carrito->total - $detalle->precio;
        $producto->save();
        $carrito->save();
        $detalle->delete();

        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Detalle_carrito';
        $afectado = $detalle->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();


        return back()->with('info', 'El detalle se ha eliminado correctamente');
    }


    public function storeP22(Request $request, $idproducto)
    {
        $pedido = Pedido::where('id', $request->idpedido)->first();
        $producto = Producto::find($idproducto);
        $detalle = new detalle_pedido();
        $detalle->producto_id = $idproducto;
        $detalle->pedido_id = $request->idpedido;
        $detalle->cantidad = $request->cantidad;


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
    }




    public function showC()
    {
        $clienteId = Auth::id();
        $carrito = Carrito::where('cliente_id', $clienteId)->first();
        $detalles = detalle_carrito::where('carrito_id', $carrito->id)->get();

        $cliente = User::where('id', $clienteId)->first();
        $productos = Producto::all();
        $tipopagos = Tipo_pago::all();
        $tipoenvios = Tipo_envio::all();
        $promociones = Promocion::all();
        $clientes = User::all();
        return view('cliente.carrito.detalle', compact('detalles', 'cliente', 'carrito', 'productos', 'tipopagos', 'tipoenvios', 'promociones', 'clientes'));
    }


    /*DESEO */
    public function indexD()
    {
        //return "2";
        //   $pedido = Pedido::where('id', $id)->first();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        //$productos = Producto::paginate(3);
        // return view('cliente.productos', compact('categorias', 'marcas', 'pedido'));
        return view('cliente.productos', compact('categorias', 'marcas'));
    }

    public function showD()
    {
        $clienteId = Auth::id();
        $deseo = Deseo::where('cliente_id', $clienteId)->first();
        $detalles = detalle_deseo::where('deseo_id', $deseo->id)->get();

        $cliente = User::where('id', $clienteId)->first();
        $productos = Producto::all();
        $tipopagos = Tipo_pago::all();
        $tipoenvios = Tipo_envio::all();
        $promociones = Promocion::all();
        $clientes = User::all();
        return view('cliente.deseo.detalle', compact('detalles', 'cliente', 'deseo', 'productos', 'tipopagos', 'tipoenvios', 'promociones', 'clientes'));
    }

    public function storeD(Request $request, $idproducto)
    {

        $request->validate([
            'cantidad' => 'required|integer',
        ]);

        $clienteId = Auth::id();

        $producto = Producto::find($idproducto);
        $deseo = Deseo::where('cliente_id', $clienteId)->first();
        $itemExistente = $deseo->productos()->where('producto_id', $idproducto)->first();

        if ($itemExistente) {
            // Si el producto ya está en el deseo, actualiza la cantidad
            $itemExistente->pivot->cantidad += $request->cantidad;
            $itemExistente->pivot->precio += $request->cantidad * $producto->precio;
            $itemExistente->pivot->save();

            // Verifica si la cantidad es mayor al stock después de actualizar el pivot
            if ($itemExistente->pivot->cantidad > $producto->stock) {
                return redirect()->route('cliente.pedidos.indexD', $deseo->id)->with('info2', 'No hay suficiente Stock de: ' . $producto->nombre);
            }

            // Descuenta el stock de productos
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Actualiza el total del deseo
            $deseo->total += $itemExistente->pivot->precio;
            $deseo->save();
        } else {
            // Si el producto no está en el deseo, agrégalo
            $deseo->productos()->attach($idproducto, ['precio' => $request->cantidad * $producto->precio, 'cantidad' =>  $request->cantidad]);

            // Verifica si la cantidad es mayor al stock después de agregar el producto al deseo
            if ($request->cantidad > $producto->stock) {
                return redirect()->route('cliente.pedidos.indexD', $deseo->id)->with('info2', 'No hay suficiente Stock de: ' . $producto->nombre);
            }

            // Descuenta el stock de productos
            $producto->stock -= $request->cantidad;
            $producto->save();

            // Actualiza el total del deseo
            $deseo->total += $request->cantidad * $producto->precio;
            $deseo->save();
        }

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'deseo';
        $afectado = $deseo->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();
        return redirect()->route('cliente.pedidos.indexD')->with('info', 'Producto Agregado correctamente');
    }

    public function createC(Request $request)
    {
        $clienteId = Auth::id();
        $deseo = Deseo::where('cliente_id', $clienteId)->first();
        $carrito = Carrito::where('cliente_id', $clienteId)->first();

        $carrito->cliente_id = $clienteId;
        $carrito->total = $carrito->total + $deseo->total;
        $carrito->save();


        $productosDeseo = $deseo->productos;

        foreach ($productosDeseo as $producto) {
            // Verifica si el producto ya está en el carrito y actualiza la cantidad si es así
            $existente = $carrito->productos()->where('producto_id', $producto->id)->first();
            if ($existente) {
                $existente->pivot->cantidad += $producto->pivot->cantidad;
                $existente->pivot->precio += $producto->pivot->precio; // Actualiza el precio
                $existente->pivot->save();
            } else {
                $carrito->productos()->attach($producto->id, [
                    'cantidad' => $producto->pivot->cantidad,
                    'precio' => $producto->pivot->precio,
                ]);
            }
        }



        // Opcional: Eliminar el carrito
        $deseo->total = 0;
        $deseo->productos()->detach(); // Esto eliminará todos los productos asociados al carrito

        $deseo->save();

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Pedido';
        $afectado = $carrito->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('cliente.carrito.showC')->with('info', 'Se a agregado los productos correctamente');
    }



    public function createCID(Request $request, $idDetalle)
    {
        $clienteId = Auth::id();
        $carrito = Carrito::where('cliente_id', $clienteId)->first();

        $deseo = Deseo::where('cliente_id', $clienteId)->first();

        $detalle_deseo = detalle_deseo::find($idDetalle);

        $carrito->total += $detalle_deseo->precio;
        $carrito->save();

        // Verifica si el producto ya está en el carrito y actualiza la cantidad si es así
        $productoEnCarrito  = $carrito->productos()->where('producto_id', $detalle_deseo->producto_id)->first();

        if ($productoEnCarrito) {
            $productoEnCarrito->pivot->cantidad += $detalle_deseo->cantidad;
            $productoEnCarrito->pivot->precio += $detalle_deseo->precio; // Actualiza el precio
            $productoEnCarrito->pivot->save();
        } else {

            $carrito->productos()->attach($detalle_deseo->producto_id, [
                'cantidad' => $detalle_deseo->cantidad,
                'precio' =>  $detalle_deseo->precio,
            ]);
        }

        $deseo->total = $deseo->total -  $detalle_deseo->precio;
        $deseo->productos()->detach($detalle_deseo->producto_id);
        $deseo->save();


        $bita = new Bitacora();
        $bita->accion = 'Agregó';
        $bita->apartado = 'Deseo';
        $afectado = $carrito->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('cliente.carrito.showC')->with('info', 'Se agregó el producto correctamente');
    }
}
