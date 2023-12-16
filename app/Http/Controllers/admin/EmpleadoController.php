<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.empleados.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.empleados.create');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8',],
            'direccion' => 'required',
            'ci' => 'required',
            'telefono' => 'required', 
            'cargo' => 'required', 
            'sueldo' => 'required|numeric'  
        ]);

        $empleado = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'ci' => $request->ci,
            'cargo' => $request->cargo,
            'sueldo' => $request->sueldo, 
            'tipo' => 'Empleado'
        ])->assignRole('Empleado');;

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Usuario';
        $afectado = $empleado->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.empleados.index')->with('info', 'El Empelado: '. $empleado->name .' se registro correctamente');

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
        $empleado = User::find($id);
        return view('admin.empleados.edit', compact('empleado'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'direccion' => 'required',
            'ci' => 'required',
            'telefono' => 'required',  
            'cargo' => 'required', 
            'sueldo' => 'required|numeric'   
        ]);
        $empleado = User::find($id);
        $data = $request->except('password');
        if (trim($request->password == '')) {
            $data = $request->except('password');
        }else{
             $data = $request->all();
             $data['password'] = bcrypt($request->password);
        }
        $empleado->update($data);

        $bita = new Bitacora();
        $bita->accion = 'Editó';
        $bita->apartado = 'Usuario';
        $afectado = $empleado->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return redirect()->route('admin.empleados.edit', $empleado->id)->with('info', 'Los datos se editaron correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $empleado = User::find($id);
        
        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Usuario';
        $afectado = $empleado->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        $empleado->delete();
        return back()->with('info','El Empleado '. $empleado->name .' se ha eliminado correctamente');
    }
}
