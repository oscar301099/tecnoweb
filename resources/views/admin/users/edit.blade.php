@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1>Editar Usuario</h1>
@stop

@section('content')

@if(session('info'))
    <div class="alert alert-success">
        <strong> {{session('info')}}</strong>
    </div>
@endif

<div class="card">
    <div class="card-body">
            
        {!! Form::model($user,['route' => ['admin.users.update', $user], 'method' => 'put', 'autocomplete' => 'off']) !!}

        <div class="row">
                <label for="id" class="col-sm-1 col-form-label">ID:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="id" value="{{$user->id}}" readonly>
                    </div>
            </div>

            <br>

            <div class="row">
                <label for="name" class="col-sm-1 col-form-label">Nombre:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="name" value="{{$user->name}}" autofocus>
                    </div>
            </div>

            <br>

            <div class="row">
                <label for="email" class="col-sm-1 col-form-label">E-Mail:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="email" value="{{$user->email}}" autofocus>
                    </div>
            </div>

            <br>

            <div class="row">
                <label for="password" class="col-sm-1 col-form-label">Contraseña:</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" name="password" placeholder="Ingrese su nueva contraseña" autofocus>
                    </div>
                    
            </div>

            <br>

            @foreach($roles as $role)
                <div>
                    <label for="">
                        {!!Form::checkbox('roles[]', $role->id, null,['class'=> 'mr-1'])!!}
                        {{$role->name}}
                    </label>
                </div>
            @endforeach
            
            <br>
            <button class="btn btn-primary" type="submit" rel="tooltip">
                <i class="material-icons fa fa-save"> Guardar</i>
            </button>
            
        {!! Form::close() !!}

    </div>
</div>
<div class="form-group col-md-4">
    <a class="btn btn-danger" href="{{route('admin.users.index')}}">
        <i class="fa fa-arrow-left"> Atras</i>
    </a>   
</div>


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@livewireStyles
@stop

@section('js')
<script>console.log('hi!')</script>
@livewireScripts
@stop
