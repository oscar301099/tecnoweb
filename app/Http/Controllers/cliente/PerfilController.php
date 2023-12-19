<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //dd('hola');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'direccion' => 'required',
            'ci' => 'required',
            'telefono' => 'required',
        ]);
        $cliente = User::find($id);

        $cliente->name = $request->name;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->ci = $request->ci;
        $cliente->telefono = $request->telefono;
        $cliente->save();


        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Usuario';
        $afectado = $cliente->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time());
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();
        return redirect()->route('cliente.perfil')->with('info', 'Los datos se editaron correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changePassword()
    {
        $cliente = Auth::user();
        return view('cliente.password', compact('cliente'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'NewPassword' => ['required','string', 'min:8'],
            'New2Password' => ['required','string', 'min:8']
        ]);

        if($request->NewPassword == $request->New2Password ){
            $cliente = Auth::user();
            $cliente->password = bcrypt($request->NewPassword);
            $cliente->save();

            $bita = new Bitacora();
            $bita->accion = 'Editó';
            $bita->apartado = 'Usuario';
            $afectado = $cliente->id;
            $bita->afectado = $afectado;
            $fecha_hora = date('m-d-Y h:i:s a', time()); 
            $bita->fecha_h = $fecha_hora;
            $bita->id_user = Auth::user()->id;
            $ip = $request->ip();
            $bita->ip = $ip;
            $bita->save();
            
            return redirect()->route('cliente.changePassword')->with('info', 'La Contraseña se ha modificado correctamente');
        }else{
            return redirect()->route('cliente.changePassword')->with('info2', 'Verificacion de contraseña incorrecta, Por favor Intente de Nuevo');
        }
    }
}