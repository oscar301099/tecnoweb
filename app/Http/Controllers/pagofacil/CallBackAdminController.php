<?php

namespace App\Http\Controllers\pagofacil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pedido;

/*use GuzzleHttp\Client;
use App\Models\Curso;
use App\Models\Video;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\DetalleVenta;
use App\Models\Progreso;*/

class CallBackAdminController extends Controller
{

    public function __invoke(Request $request)
    {

        $pago_id = $request->input("PedidoID");
        $Fecha = $request->input("Fecha");
        $NuevaFecha = date("Y-m-d", strtotime($Fecha));
        $Hora = $request->input("Hora");
        $MetodoPago = $request->input("MetodoPago");
        $Estado = $request->input("Estado");
        $Ingreso = true;
        
        try {
            $pedido = Pedido::where('tcNroPago', $pago_id)->first();
            if (!empty($pedido)) {
                $pedido->estado_pago = 'Pagado';
                $pedido->update();
                $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'values' => true];
            } else {
                $arreglo = ['error' => 1, 'status' => 1, 'message' => "No se encontró un pedido con el número de pago proporcionado.", 'values' => false];
            }
        } catch (\Throwable $th) {
            $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'values' => false];
        }
        return response()->json($arreglo);
    }
}