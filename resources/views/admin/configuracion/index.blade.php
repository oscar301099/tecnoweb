@extends('adminlte::page')

@section('title', 'Configuraciones')

@section('content_header')
    <h1>Configuraciones</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong> {{ session('info') }}</strong>
        </div>
    @endif

    
<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-md-4">
                <p class="h5">ID: </p>
                <p class="form-control">{{$configuracion->id}}</p>
            </div>

            <div class="form-group col-md-4">
                <p class="h5">Razon Social: </p>
                <p class="form-control">{{$configuracion->razon_social}}</p>
            </div>

            <div class="form-group col-md-4">
                <p class="h5">Nro de Factura: </p>
                <p class="form-control">{{$configuracion->factura}}</p>
            </div>

        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <p class="h5">E-mail: </p>
                <p class="form-control">{{$configuracion->email}}</p>
            </div>

            <div class="form-group col-md-4">
                <p class="h5">Telefono: </p>
                <p class="form-control">{{$configuracion->telefono}}</p>
            </div>

            <div class="form-group col-md-4">
                <p class="h5">Direccion: </p>
                <p class="form-control">{{$configuracion->direccion}}</p>
            </div>

        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <p class="h5">Responsable: </p>
                <p class="form-control">{{$configuracion->responsable}}</p>
            </div>


        </div>

        <a class="btn btn-warning" href="{{route('admin.configuracion.edit', 1)}}">
                <i class="fa fa-pen"></i> 
                Editar
        </a>
        <button id="cambiarModo" class="btn btn-info">Cambiar Modo</button>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modoActual = localStorage.getItem('modo') || 'dia';
            aplicarModo(modoActual);
        });

        function aplicarModo(modo) {
            // Cambiar el filtro de brillo en el cuerpo
            document.body.style.filter = `brightness(${modo === 'dia' ? '100%' : '70%'})`;

            // Cambiar las clases de fondo y texto en la tarjeta si existe
            const tarjeta = document.getElementById('card-body');

            if (tarjeta) {
                if (modo === 'noche') {
                    tarjeta.style.backgroundColor = '#ffffff'; // Fondo blanco
                    tarjeta.style.color = '#000000'; // Texto negro
                } else {
                    tarjeta.style.backgroundColor = '#000000'; // Fondo negro
                    tarjeta.style.color = '#ffffff'; // Texto blanco
                }
            }
        }

        document.getElementById('cambiarModo').addEventListener('click', function () {
            const modoActual = localStorage.getItem('modo') || 'dia';
            const nuevoModo = modoActual === 'dia' ? 'noche' : 'dia';
            localStorage.setItem('modo', nuevoModo);
            aplicarModo(nuevoModo);
        });
    </script>
@stop
