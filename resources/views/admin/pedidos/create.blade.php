@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
    <h1 class="text-center">Registar Pedido</h1>

@stop

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4><strong>Datos</strong></h1>
                    </div>
                    <div class="card-body">

                        {!! Form::open(['route' => 'admin.pedidos.store', 'autocomplete' => 'off']) !!}

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Cliente: </label>
                                <select name=cliente_id id=cliente_id class="form-control">
                                    <option value="">-- Escoja el cliente --</option>

                                    @foreach ($clientes as $cliente)
                                        @if ($cliente->tipo == 'Cliente')
                                            <option value="{{ $cliente['id'] }}">{{ $cliente['name'] }}</option>
                                        @endif
                                    @endforeach

                                </select>

                                @error('cliente_id')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                {!! Form::label('direccion', 'Direccion: ') !!}
                                {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la direcion']) !!}

                                @error('direccion')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                        </div>


                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Tipo de Entrega: </label>
                                <select name=tipoEnvio_id id=tipoEnvio_id class="form-control">
                                    <option value="">-- Escoja la entrega --</option>

                                    @foreach ($tipoenvios as $envio)
                                        <option value="{{ $envio['id'] }}">{{ $envio['nombre'] }}</option>
                                    @endforeach

                                </select>

                                @error('tipoEnvio_id')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Tipo de Pago: </label>
                                <select name=tipoPago_id id=tipoPago_id class="form-control">
                                    <option value="">-- Escoja el Pago --</option>

                                    @foreach ($tipopagos as $pago)
                                        <option value="{{ $pago['id'] }}">{{ $pago['nombre'] }}</option>
                                    @endforeach

                                </select>

                                @error('tipoPago_id')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Promocion: </label>
                                <select name=promocion_id id=promocion_id class="form-control">
                                    <option value="">-- Ninguna --</option>

                                    @foreach ($promociones as $promocion)
                                        <option value="{{ $promocion['id'] }}">{{ $promocion['nombre'] }} ---->
                                            {{ $promocion['porcentaje'] }}%</option>
                                    @endforeach

                                </select>

                                @error('promocion_id')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-2">
                                <a class="btn btn-danger" href="{{ route('admin.pedidos.index') }}">
                                    <i class="fa fa-arrow-left"> Atras</i>
                                </a>
                            </div>

                            <div class="form-group col-md-2">
                                <button class="btn btn-primary" type="submit" rel="tooltip">
                                    <i class="material-icons fa fa-save"> Registrar Pedido</i>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productos').DataTable();
        });
    </script>
@stop
