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
        <button id="cambiarModo" class=" hover:text-gray-300">Cambiar Modo</button>
                    <button id="aumentarLetra" class="hover:text-gray-300">Aumentar Letra</button>
                    <button id="disminuirLetra" class="hover:text-gray-300">Disminuir Letra</button>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
        document.addEventListener("DOMContentLoaded", function () {
            const botonCambiarModo = document.getElementById('cambiarModo');
            let modoActual = localStorage.getItem('modo') || 'dia';
            aplicarModo(modoActual);
            botonCambiarModo.addEventListener('click', function () {
                modoActual = modoActual === 'dia' ? 'noche' : 'dia';
                localStorage.setItem('modo', modoActual);
                aplicarModo(modoActual);
            });

            function aplicarModo(modo) {
                document.body.style.backgroundImage = `url('${modo === 'dia' ? 'URL_DE_TU_IMAGEN_DIURNA' : 'URL_DE_TU_IMAGEN_NOCTURNA'}')`;
                document.body.style.filter = `brightness(${modo === 'dia' ? '100%' : '70%'})`;
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const botonCambiarModo = document.getElementById('cambiarModo');
            const botonAumentarLetra = document.getElementById('aumentarLetra');
            const botonDisminuirLetra = document.getElementById('disminuirLetra');
            let contrasteActual = localStorage.getItem('contraste') || 'normal';
            let tamanioLetraActual = localStorage.getItem('tamanioLetra') || '16px';

            aplicarContraste(contrasteActual);
            aplicarTamanioLetra(tamanioLetraActual);

            botonCambiarModo.addEventListener('click', function () {
                contrasteActual = contrasteActual === 'normal' ? 'alto' : 'normal';
                localStorage.setItem('contraste', contrasteActual);
                aplicarContraste(contrasteActual);
            });

            botonAumentarLetra.addEventListener('click', function () {
                tamanioLetraActual = aumentarTamanioLetra(tamanioLetraActual);
                localStorage.setItem('tamanioLetra', tamanioLetraActual);
                aplicarTamanioLetra(tamanioLetraActual);
            });

            botonDisminuirLetra.addEventListener('click', function () {
                tamanioLetraActual = disminuirTamanioLetra(tamanioLetraActual);
                localStorage.setItem('tamanioLetra', tamanioLetraActual);
                aplicarTamanioLetra(tamanioLetraActual);
            });

            function aplicarContraste(contraste) {
                document.body.classList.toggle('alto-contraste', contraste === 'alto');
            }

            function aumentarTamanioLetra(tamanioActual) {
                const tamanioNumerico = parseInt(tamanioActual);
                return `${tamanioNumerico + 2}px`;
            }

            function disminuirTamanioLetra(tamanioActual) {
                const tamanioNumerico = parseInt(tamanioActual);
                return `${Math.max(tamanioNumerico - 2, 12)}px`;
            }

            function aplicarTamanioLetra(tamanio) {
                document.body.style.fontSize = tamanio;
            }
        });
    </script>
@stop
