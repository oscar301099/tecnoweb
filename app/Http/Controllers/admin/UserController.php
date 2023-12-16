<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoredUserRequest;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));    

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoredUserRequest $request){
        $user = User::create($request->all());
        $user['password'] = bcrypt($request->password);
        $user->save();
        $user->roles()->sync($request->roles);

        $bita = new Bitacora();
        $bita->accion = 'Registró';
        $bita->apartado = 'Usuario';
        $afectado = $user->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();



        return redirect()->route('admin.users.index')->with('info', 'Se creo el usuario correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user){

        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user){

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user){
        
        $data = $request->only('id','name', 'email');

        if (trim($request->password == '')) {
            $data = $request->except('password');
        }else{
             $data = $request->all();
             $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        $user->roles()->sync($request->roles);




        return redirect()->route('admin.users.edit', $user)->with('info', 'Se editaron los datos correctamente');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user){
        $user->delete();
        $bita = new Bitacora();
        $bita->accion = 'Eliminó';
        $bita->apartado = 'Usuario';
        $afectado = $user->id;
        $bita->afectado = $afectado;
        $fecha_hora = date('m-d-Y h:i:s a', time()); 
        $bita->fecha_h = $fecha_hora;
        $bita->id_user = Auth::user()->id;
        $ip = $request->ip();
        $bita->ip = $ip;
        $bita->save();

        return back()->with('info','El Usuario ha sido eliminado correctamente');
    }

}
