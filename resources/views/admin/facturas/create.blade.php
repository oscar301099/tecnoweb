@extends('adminlte::page')

@section('title', 'Registrar Cliente')

@section('content_header')
    <h1>Registrar Factura</h1>

@stop

@section('content')
@if (session('info'))
<div class="alert alert-danger">
    <strong> {{ session('info') }}</strong>
</div>
@endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4><strong>Datos</strong></h1>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'admin.facturas.store', 'autocomplete' => 'off']) !!}

                        <div class="from-group col-md-6">
                            <label for="">Pedido: </label>
                            <select name=pedido_id id=pedido_id class="form-control">
                                <option value="">-- Escoja el Pedido --</option>

                                @foreach ($pedidos as $pedido)
                                    @foreach ($clientes as $cliente)
                                        @if ($pedido->cliente_id == $cliente->id)
                                            <option value="{{ $pedido['id'] }}">{{ $pedido->id }} ---
                                                {{ $cliente['name'] }}</option>
                                        @endif
                                    @endforeach
                                @endforeach

                            </select>

                            @error('pedido_id')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>


                    <div class="row">

                        <div class="form-group col-md-2">
                            <a class="btn btn-danger" href="{{ route('admin.facturas.index') }}">
                                <i class="fa fa-arrow-left"> Atras</i>
                            </a>
                        </div>

                        <div class="form-group col-md-2">
                            <button class="btn btn-primary" type="submit" rel="tooltip">
                                <i class="material-icons fa fa-save"> Registrar</i>
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
    </div>



@stop

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
