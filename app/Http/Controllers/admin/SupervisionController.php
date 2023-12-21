<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupervisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidosPorMes = Pedido::selectRaw('
        EXTRACT(YEAR FROM created_at) || \'-\' || EXTRACT(MONTH FROM created_at) as mes,
        COUNT(id) as total_pedidos
    ')
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();
        $mesesCompletos = array_fill(1, 12, 0);

        foreach ($pedidosPorMes as $pedido) {
            $parts = explode('-', $pedido->mes);
            $mes = (int)end($parts);
            $mesesCompletos[$mes] = $pedido->total_pedidos;
        }


        //producto mas vendido
        $topProductos = Producto::select(
            'productos.nombre as nombre',
            DB::raw('COUNT(detalle_pedidos.id) as cantidad')
        )
            ->leftJoin('detalle_pedidos', 'productos.id', '=', 'detalle_pedidos.producto_id')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('cantidad')
            ->limit(6)
            ->get();

        // Ingresos Total

        $totalxmes = Pedido::selectRaw('
        EXTRACT(YEAR FROM created_at) || \'-\' || EXTRACT(MONTH FROM created_at) as mes,
        SUM(total) as total_ventas
    ')
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

            $ingresoxmes = array_fill(1, 12, 0);

            foreach ($totalxmes as $pedido) {
                $parts = explode('-', $pedido->mes);
                $mes = (int)end($parts);
                $ingresoxmes[$mes] = $pedido->total_ventas;
            }
            
        return view('admin.supervision.index', compact('mesesCompletos', 'topProductos','ingresoxmes'));
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
    public function create()
    {
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
    public function update(Request $request, $id)
    {
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

        return back()->with('info', 'La Promocion ha sido eliminado correctamente');
    }
}