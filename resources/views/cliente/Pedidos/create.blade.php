@extends('layouts.cliente')

@section('title', 'Detalles de Pedido')

@section('content_header')
<h1 class="text-center">Registar Pedido</h1>
@stop
@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-white text-center">
                    <h4><strong>Datossssss</strong></h1>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => 'cliente.pedidos.store', 'autocomplete' => 'off']) !!}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Cliente: </label>
                            <input style=" width: 350px;" type="text" class="form-control" name="cliente_id" id="cliente_id" value="{{ $clientes->id }}" readonly required>
                            @error('cliente_id')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('direccion', 'Direccion: ') !!}
                            {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la direcion', 'required']) !!}
                            @error('direccion')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Tipo de Entrega: </label>
                            <select name="tipoEnvio_id" id="tipoEnvio_id" class="form-control" required>
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
                            <select name="tipoPago_id" id="tipoPago_id" class="form-control" required>
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
                            <label for="">Pomocion: </label>
                            <select name="promocion_id" id="promocion_id" class="form-control">
                                <option value="">-- Ninguna --</option>
                                @foreach ($promociones as $promocion)
                                <option value="{{ $promocion['id'] }}">{{ $promocion['nombre'] }} ---->
                                    {{ $promocion['porcentaje'] }}%
                                </option>
                                @endforeach
                            </select>
                            @error('promocion_id')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
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

<br>




@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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