@extends('layouts.cliente')

@section('title', 'Elegir Productos')

@section('content')
@livewire('productos-p', ['pedido' => $pedido])

@endsection

<h1>Agregar carrito a partir de un pedido ya creado</h1>
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @livewireStyles
@stop

@section('js')
    <script>
        console.log('hi!')
    </script>
    @livewireScripts
@stop