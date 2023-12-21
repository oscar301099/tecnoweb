<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContadorPage;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteControlle extends Controller
{
   public function index(){
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

        $pagina = ContadorPage::all();
        

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
        
    return view('admin.reporte.index', compact('mesesCompletos', 'pagina','ingresoxmes',));
    }
}
