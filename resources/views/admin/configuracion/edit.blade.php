@extends('adminlte::page')

@section('title', 'Editar Configuraciones')

@section('content_header')
<h1>Configuracion:</h1>
@stop

@section('content')

@if(session('info'))
    <div class="alert alert-success">
        <strong> {{session('info')}}</strong>
    </div>
@endif

<div class="card">
    <div class="card-body">
        {!! Form::model($configuracion,['route' => ['admin.configuracion.update', $configuracion->id], 'method' => 'put', 'autocomplete' => 'off']) !!}


            <div class="row">
                <div class="form-group col-md-4">
                    <label for="id" class="">ID:</label>
                    <input type="text" class="form-control" name="id" value="{{$configuracion->id}}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="razon_social" class="">Razon Social:</label>
                    <input type="text" class="form-control" name="razon_social" value="{{$configuracion->razon_social}}" autofocus required>
                </div>

                <div class="form-group col-md-4">
                    <label for="factura" class="">Factura:</label>
                    <input type="text" class="form-control" name="factura" value="{{$configuracion->factura}}" autofocus required > 
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="email" class="">E-Mail:</label>
                    <input type="text" class="form-control" name="email" value="{{$configuracion->email}}" autofocus required>
                </div>

                <div class="form-group col-md-4">
                    <label for="telefono" class="">Telefono:</label>
                    <input type="text" class="form-control" name="telefono" value="{{$configuracion->telefono}}" pattern="\+[1-9]\d*" title="Prefijo de país seguido de un número" autofocus required>  
                </div>

                <div class="form-group col-md-4">
                    <label for="direccion" class="">Direccion:</label>
                    <input type="text" class="form-control" name="direccion" value="{{$configuracion->direccion}}" autofocus required>    
                </div>

            </div>

            <div class="row">


                <div class="form-group col-md-4">
                    <label for="responsable" class="">Responsable:</label>
                    <input type="text" class="form-control" name="responsable" value="{{$configuracion->responsable}}" autofocus>
                </div>

            </div>

            {!! Form::submit('Guardar', ['class' => 'btn btn-info mt-2'])!!}

        {!! Form::close() !!}
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>console.log('hi!')</script>
@stop
