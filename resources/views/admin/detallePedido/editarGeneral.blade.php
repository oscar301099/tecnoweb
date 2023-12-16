@extends('adminlte::page')

@section('title', 'Editar Detalle')

@section('content_header')
    <h1>Editar Venta del producto</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong> {{ session('info') }}</strong>
        </div>
    @endif
    @if (session('info2'))
        <div class="alert alert-danger">
            <strong> {{ session('info2') }}</strong>
        </div>
    @endif
    <br>

    <div class="card">
        <div class="card-body">

            {!! Form::model($detalle, ['route' => ['admin.detalle_pedidos.update', $detalle->id], 'method' => 'put', 'autocomplete' => 'off']) !!}

            <div class="row">
                <div class="form-group col-md-1">
                    {!! Form::label('pedido', 'Pedido') !!}
                    <input type="text" class="form-control" value="{{ $detalle->pedido_id }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    {!! Form::label('producto', 'Producto') !!}
                    @foreach ($productos as $producto)
                        @if ($producto->id == $detalle->producto_id)
                            <input type="text" class="form-control" value="{{ $producto->nombre }}" readonly>
                        @endif
                    @endforeach
                </div>

                <div class="form-group col-md-2">
                    {!! Form::label('stock', 'Stock Disponible') !!}
                    @foreach ($productos as $producto)
                        @if ($producto->id == $detalle->producto_id)
                            <input type="text" class="form-control" value="{{ $producto->stock }}" readonly>
                        @endif
                    @endforeach
                </div>

                <div class="form-group col-md-2">
                    {!! Form::label('precioP', 'Precio del Producto') !!}
                    @foreach ($productos as $producto)
                        @if ($producto->id == $detalle->producto_id)
                            <input type="text" class="form-control" value="{{ $producto->precio }}" readonly>
                        @endif
                    @endforeach
                </div>

                <div class="form-group col-md-3">
                    {!! Form::label('cantidad', 'Cantidad') !!}
                    {!! Form::text('cantidad', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la cantidad']) !!}
                    @error('cantidad')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
                </div>
            </div>


            <br>

            <div class="form-group">
                <button class="btn btn-primary" type="submit" rel="tooltip">
                    <i class="material-icons fa fa-save"> Guardar</i>
                </button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    <div class="form-group col-md-4">
        <a class="btn btn-danger" href="{{ route('admin.detalle_pedidos.index') }}">
            <i class="fa fa-arrow-left"> Atras</i>
        </a>
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
