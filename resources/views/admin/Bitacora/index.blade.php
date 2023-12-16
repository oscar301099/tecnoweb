@extends('adminlte::page')

@section('title', 'Bitacora')

@section('content_header')
<h1>Bitacora Dinamica:</h1>

@stop

@section('content')
<button id="cambiarModo" class="btn btn-info">Cambiar Modo</button>
    @if(session('info'))
        <div class="alert alert-success">
            <strong> {{session('info')}}</strong>
        </div>
        @endif
        
@livewire('bitacora-index')


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@livewireStyles
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
@livewireScripts
@stop

