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
            
        {!! Form::model($proveedor,['route' => ['admin.proveedores.update', $proveedor], 'method' => 'put', 'autocomplete' => 'off']) !!}

        <div class="row">
                <label for="id" class="col-sm-1 col-form-label">ID:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="id" value="{{$proveedor->id}}" readonly>
                    </div>
            </div>

            <br>

            <div class="row">
                <label for="nombre" class="col-sm-1 col-form-label">Nombre:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="nombre" value="{{$proveedor->nombre}}" autofocus>
                    </div>
            </div>

            <br>

            <div class="row">
                <label for="direccion" class="col-sm-1 col-form-label">E-Mail:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="direccion" value="{{$proveedor->direccion}}" autofocus>
                    </div>
            </div>

            <br>

            <div class="row">
                <label for="telefono" class="col-sm-1 col-form-label">Contraseña:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="telefono" value="{{$proveedor->telefono}}" autofocus>
                    </div>
                    
            </div>

            <br>

            <button class="btn btn-primary" type="submit" rel="tooltip">
                <i class="material-icons fa fa-save"> Guardar</i>
            </button>
            
        {!! Form::close() !!}

    </div>
</div>
<div class="form-group col-md-4">
    <a class="btn btn-danger" href="{{route('admin.proveedores.index')}}">
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
