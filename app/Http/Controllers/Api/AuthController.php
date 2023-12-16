<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\detalle_pedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\Tipo_envio;
use App\Models\Tipo_pago;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        /* if($request->name = '' || $request->password == '')
            return response()->json(['message' => 'These credentials do not match our records.'], 404); */

        if(!DB::table('users')->where('email', $request->email)->exists()){
            return response()->json(['message' => 'Correo Electronico Inexistente'], 404);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        //hash para ver si son iguales
        if($user->tipo == 'Cliente'){
            if(Hash::check($request->password, $user->password)){
                return $user;
            }else{
                return response()->json(['message' => 'Contraseña Incorrecta'], 404);
            }
        }else{
            //
            return response()->json(['message' => 'Rol Desconocido'], 404);
        }
    }

    public function configuration(){
        $datos = DB::table('configurations')->where('id',1)->first();
        return $datos;
    }

    public function Productos(){
        $datos = DB::table('productos')->get();


        $datos = Producto::join('categorias', 'productos.categoria_id', 'categorias.id')
        ->join('marcas', 'productos.marca_id', 'marcas.id')
        ->select('productos.id', 'productos.nombre','productos.descripcion', 'productos.precio', 'productos.stock', 'productos.imagen','categorias.nombre as categoria', 'marcas.nombre as marca')
        ->get();


        return $datos;
    }

    public function UpdatePerfil(Request $request, $id){

        $cliente = User::find($id);

        if (is_null($request->name)) {
            $cliente->name = $cliente->name;
        }else{
            $cliente->name = $request->name;
        }
        if (is_null($request->email)) {
            $cliente->email = $cliente->email;
        }else{
            $cliente->email = $request->email;
        }
        if (is_null($request->direccion)) {
            $cliente->direccion= $cliente->direccion;
        }else{
            $cliente->direccion = $request->direccion;
        }
        if (is_null($request->ci)) {
            $cliente->ci = $cliente->ci;
        }else{
            $cliente->ci = $request->ci;
        }
        if (is_null($request->telefono)) {
            $cliente->telefono = $cliente->telefono;
        }else{
            $cliente->telefono = $request->telefono;
        }

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Usuario';
        $afectado = $cliente->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = $cliente->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        $cliente->save();
        return $cliente;
    }

    public function UpdatePassword(Request $request, $id){
        $request->validate([
            'newpass' => ['required','string', 'min:8'],
            'newnewpass' => ['required','string', 'min:8']
        ]);

        if($request->newpass == $request->newnewpass ){
            $cliente = User::find($id);
            $cliente->password = bcrypt($request->newpass);
            $cliente->save();

            $bita = new Bitacora();
            $bita->accion = 'Editó';
            $bita->apartado = 'Usuario';
            $afectado = $cliente->id;
            $bita->afectado = $afectado;
            $fecha_hora = date('m-d-Y h:i:s a', time()); 
            $bita->fecha_h = $fecha_hora;
            $bita->id_user = $cliente->id;
            $ip = $request->ip();
            $bita->ip = $ip;
            //$bita->save();
            return $cliente;
        }else{
            return response()->json(['message' => 'Contraseñas incorrectas'], 404);
        }
    }

    public function pedidos($id){
        $pedidos = DB::table('pedidos')->where('cliente_id', $id)->get();

        return $pedidos;
    }

    public function addProducto(Request $request){

        //body: cantidad  idproducto  idpedido

        $pedido = Pedido::where('id',$request->idpedido)->first();
        $producto = Producto::find($request->idproducto);
        $detalle = new detalle_pedido();
        $detalle->producto_id = $request->idproducto;
        $detalle->pedido_id = $request->idpedido;
        $detalle->cantidad = $request->cantidad;
        //si la cantidad es mayor al stock
        if($detalle->cantidad > $producto->stock){
            return response()->json(['message' => 'No hay suficiente Stock de: '. $producto->nombre], 404);
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
        $bita->id_user = $pedido->cliente_id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();
        return $producto;

    }

    public function pedido_detalle($id){
        //$detalles = DB::table('detalle_pedidos')->where('pedido_id', $id)->get();

        $detalles = detalle_pedido::join('productos', 'detalle_pedidos.producto_id', 'productos.id')
        ->select('detalle_pedidos.id', 'productos.nombre as nombreProducto','productos.precio as precioProducto', 'detalle_pedidos.cantidad', 'detalle_pedidos.precio')
        ->where('detalle_pedidos.pedido_id', $id)
        ->get();


        return $detalles;
    }

    public function deleteDetalle(Request $request, $id){
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
        $bita->id_user = $pedido->cliente_id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();
        return $detalle;
    }

    public function tipoPagos(){
        //$tipopagos = Tipo_pago::all()->select('id','nombre');
        $tipopagos = DB::table('tipo_pagos')->select('id','nombre')->get();
        return $tipopagos;
    }

    public function tipoEnvios(){
        $tipoenvios = DB::table('tipo_envios')->select('id','nombre')->get();
        return $tipoenvios;
    }

    public function promociones(){
        $promociones = DB::table('promocions')->select('id','nombre')->get();
        return $promociones;
    }

    public function storePedido(Request $request)
    {
        if($request->tipoEnvio == ''){
            return response()->json(['message' => 'faltan datos'], 404);
        }
        if($request->tipoPago == ''){
            return response()->json(['message' => 'faltan datos'], 404);
        }
        if($request->cliente_id == ''){
            return response()->json(['message' => 'faltan datos'], 404);
        }


        $user = User::find($request->cliente_id);
        $envio = DB::table('tipo_envios')->where('nombre', $request->tipoEnvio)->first();
        $pago = DB::table('tipo_pagos')->where('nombre', $request->tipoPago)->first();
        $promo = DB::table('promocions')->where('nombre', $request->promocion)->first();

        $pedido = New Pedido();
        $pedido->direccion = $user->direccion;
        $pedido->tipoEnvio_id = $envio->id;
        $pedido->tipoPago_id = $pago->id;
        $pedido->promocion_id = $promo->id;
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
        $bita->id_user = $request->cliente_id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();
        return $pedido;

    }

}
