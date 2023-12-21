<?php

namespace App\Http\Controllers\pagofacil;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\detalle_pedido;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\Promocion;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsumirServicioController extends Controller
{
    public function RecolectarDatos(Request $request)
    {
        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = $request->tnTelefono;
            $lcNombreUsuario       = $request->tcRazonSocial;
            $lnCiNit               = $request->tcCiNit;
            $lcNroPago             = "test-" . rand(100000, 999999);
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo              = $request->tcCorreo;
            $lcUrlCallBack         = "http://localhost:8000/";
            $lcUrlReturn           = "http://localhost:8000/";
            $laPedidoDetalle       = $request->taPedidoDetalle;
            $lcUrl                 = "";


            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody,
                'verify' => false, // Desactivar la verificación SSL
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                $laValues = explode(";", $laResult->values)[1];

                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
            } elseif ($request->tnTipoServicio == 2) {

                $csrfToken = csrf_token();

                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p><p id="tnTransaccion" class="blue-text">' . $laResult->values . '</p><br>';
                echo '<iframe name="QrImage" style="width: 100%; height: 300px;"></iframe>';
                echo '<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>';

                echo '<script>
                        $(document).ready(function() {
                            function hacerSolicitudAjax(numero) {
                                // Agrega el token CSRF al objeto de datos
                                var data = { _token: "' . $csrfToken . '", tnTransaccion: numero };
                                
                                $.ajax({
                                    url: \'/consultar\',
                                    type: \'POST\',
                                    data: data,
                                    success: function(response) {
                                        var iframe = document.getElementsByName(\'QrImage\')[0];
                                        iframe.contentDocument.open();
                                        iframe.contentDocument.write(response.message);
                                        iframe.contentDocument.close();
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }

                            setInterval(function() {
                                hacerSolicitudAjax(' . $laResult->values . ');
                            }, 7000);
                        });
                    </script>';
            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }

    public function generarQr(Request $request)
    {

        $pedido = Pedido::find($request->pedido_id);
        $cliente = User::find($pedido->cliente_id);

        $this->CreateFactura($request->pedido_id);

        $detalle = DB::table('detalle_pedidos')
            ->join('productos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            ->select(
                'productos.id as Serial',
                'productos.nombre as Producto',
                'detalle_pedidos.cantidad as Cantidad',
                'productos.precio as Precio',
            )
            ->where('detalle_pedidos.pedido_id', $pedido->id)
            ->get();


        $detalle_pedido = $detalle->map(function ($detalle) {
            $detalle->Descuento = '0.00';
            $detalle->Total = $detalle->Precio * $detalle->Cantidad;
            return collect($detalle)->map(function ($valor) {
                return strval($valor);
            })->all();
        });




        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = $cliente->telefono;
            $lcNombreUsuario       = $cliente->name;
            $lnCiNit               = $cliente->ci;
            $lcNroPago             = "grup013sc-" . rand(100000, 999999);
            $lnMontoClienteEmpresa = $pedido->total;
            $lcCorreo              = $cliente->email;
            //$lcUrlCallBack         = "https://mail.tecnoweb.org.bo/inf513/grupo13sc/tecnoweb/public/venta/pagos/callback";
            $lcUrlCallBack         = route('admin.pagos.callback');
            $lcUrlReturn           = route('cliente.pedidos.index');
            $laPedidoDetalle       = $detalle_pedido;
            $lcUrl                 = "";

            //$arreglo['detalle']=$detalle_pedido;
            //$arreglo['total']=$pedido->total;

            //return response()->json($arreglo);

            if (Auth::user()->ci == null || Auth::user()->telefono == null) {
                $arreglo = ['error' => '¡Hola! Por favor, actualiza tu Perfil,cédula de identidad y número de teléfono. ¡Gracias!'];
                return response()->json($arreglo);
            }

            if ($pedido->total == 0) {
                $arreglo = ['error' => 'PAGO FACIL NO PUDO GENERAR QR 0.0Bs !!!'];
                return response()->json($arreglo);
            }

            $pedido->tcNroPago = $lcNroPago;
            $pedido->update();

            $arreglo['pedido_id'] = $request->pedido_id;
            $arreglo['lnTelefono'] = $lnTelefono;
            $arreglo['lcNombreUsuario'] = $lcNombreUsuario;
            $arreglo['lnCiNit'] = $lnCiNit;
            $arreglo['lcNroPago'] = $lcNroPago;
            $arreglo['lnMontoClienteEmpresa'] = $lnMontoClienteEmpresa;
            $arreglo['urlCall'] = $lcUrlCallBack;
            $arreglo['urlReturn'] = $lcUrlReturn;
            $arreglo['lcCorreo'] = $lcCorreo;
            $arreglo['laPedidoDetalle'] = $laPedidoDetalle;
            $arreglo['pedido'] = $pedido;
            $arreglo['detalle'] =   $detalle_pedido;

            $loClient = new Client();

            if (true) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];



            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody,
                'verify' => false, // Desactivar la verificación SSL
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if (true) {

                $laValues = explode(";", $laResult->values)[1];

                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                $arreglo = ['img' => $laQrImage];
                return response()->json($arreglo);
                //echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
            } elseif ($request->tnTipoServicio == 2) {

                $csrfToken = csrf_token();

                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p><p id="tnTransaccion" class="blue-text">' . $laResult->values . '</p><br>';
                echo '<iframe name="QrImage" style="width: 100%; height: 300px;"></iframe>';
                echo '<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>';

                echo '<script>
                        $(document).ready(function() {
                            function hacerSolicitudAjax(numero) {
                                // Agrega el token CSRF al objeto de datos
                                var data = { _token: "' . $csrfToken . '", tnTransaccion: numero };
                                
                                $.ajax({
                                    url: \'/consultar\',
                                    type: \'POST\',
                                    data: data,
                                    success: function(response) {
                                        var iframe = document.getElementsByName(\'QrImage\')[0];
                                        iframe.contentDocument.open();
                                        iframe.contentDocument.write(response.message);
                                        iframe.contentDocument.close();
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }

                            setInterval(function() {
                                hacerSolicitudAjax(' . $laResult->values . ');
                            }, 7000);
                        });
                    </script>';
            }
        } catch (\Throwable $th) {
            // $arreglo = ['error' => $th->getMessage() . " - " . $th->getLine()];
            $arreglo = ['error' => '"Error de conexión , intente después."'];
        }
        return response()->json($arreglo);
    }


    public function CreateFactura($id)
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
        $pedido->save();
    }

    public function ConsultarEstado(Request $request)
    {
        $lnTransaccion = $request->tnTransaccion;

        $loClientEstado = new Client();

        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];

        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => $lnTransaccion
        ];

        $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
            'headers' => $laHeaderEstadoTransaccion,
            'json' => $laBodyEstadoTransaccion
        ]);

        $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());

        $texto = '<h5 class="text-center mb-4">Estado Transacción: ' . $laResultEstadoTransaccion->values->messageEstado . '</h5><br>';

        return response()->json(['message' => $texto]);
    }

    public function urlCallback(Request $request)
    {
        $Venta = $request->input("PedidoID");
        $Fecha = $request->input("Fecha");
        $NuevaFecha = date("Y-m-d", strtotime($Fecha));
        $Hora = $request->input("Hora");
        $MetodoPago = $request->input("MetodoPago");
        $Estado = $request->input("Estado");
        $Ingreso = true;

        try {
            $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'values' => true];
        } catch (\Throwable $th) {
            $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'values' => false];
        }
        return response()->json($arreglo);
    }
}
