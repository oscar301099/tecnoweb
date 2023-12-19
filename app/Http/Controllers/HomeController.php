<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Categoria;
use App\Models\Configuration;
use App\Models\ContadorPage;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $nombrepagina="home";
        DB::beginTransaction();
        ContadorPage::SumarContador($nombrepagina);
        DB::commit();

        if (auth()->user()->tipo == 'Administrador') {
            $configuration = Configuration::find(1);

            $bita = new Bitacora();
            $bita->accion = 'Inició Sesión';
            $bita->apartado = 'Usuario';
            $afectado = Auth::user()->id;
            $bita->afectado = $afectado;
            $fecha_hora = date('m-d-Y h:i:s a', time()); 
            $bita->fecha_h = $fecha_hora;
            $bita->id_user = Auth::user()->id;
            $ip = $request->ip();
            $bita->ip = $ip;
            $bita->save();

            return view('admin.index', compact('configuration'));
        } else {
            if (auth()->user()->tipo == 'Cliente') {
                $categorias = Categoria::all();
                $productos = Producto::paginate(3);
                $marcas = Marca::all();

                $bita = new Bitacora();
                $bita->accion = 'Inició Sesión';
                $bita->apartado = 'Usuario';
                $afectado = Auth::user()->id;
                $bita->afectado = $afectado;
                $fecha_hora = date('m-d-Y h:i:s a', time()); 
                $bita->fecha_h = $fecha_hora;
                $bita->id_user = Auth::user()->id;
                $ip = $request->ip();
                $bita->ip = $ip;
                $bita->save();
                
                return view('cliente.index', compact('productos', 'marcas', 'categorias'));
            } else {
                if (auth()->user()->tipo == 'Empleado') {
                    $configuration = Configuration::find(1);

                    $bita = new Bitacora();
                    $bita->accion = 'Inició Sesión';
                    $bita->apartado = 'Usuario';
                    $afectado = Auth::user()->id;
                    $bita->afectado = $afectado;
                    $fecha_hora = date('m-d-Y h:i:s a', time()); 
                    $bita->fecha_h = $fecha_hora;
                    $bita->id_user = Auth::user()->id;
                    $ip = $request->ip();
                    $bita->ip = $ip;
                    $bita->save();
                    
                    return view('admin.index', compact('configuration'));
                }
            }
        }
    }
}
