@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
    <a class="btn btn-danger float-left" href="{{ route('admin.pedidos.index') }}">
        <i class="fa fa-arrow-left"> Atras</i>
    </a>
    <h1 class="float-right">
        <strong>Productos del Pedido:</strong> {{ $pedido->id }}
    </h1>

@stop

@section('content')
<br>

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

    <div class="card-body">
        <table class="table table-striped" id="productos">
            <thead>
                <tr>
                    <th style=" width: 100px;">Nombre</th>
                    <th style=" width: 200px;">Descripcion</th>
                    <th style=" width: 100px;">Marca</th>
                    <th style=" width: 100px;">Precio</th>
                    <th style=" width: 50px;">Stock</th>
                    <th style=" width: 150px;">Imagen</th>
                    <th style=" width: 100px;"></th>
                    <th style=" width: 100px;"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>
                            @foreach ($marcas as $marca)
                                @if ($producto->marca_id == $marca->id)
                                    {{ $marca->nombre }}
                                @endif
                            @endforeach
                        </td>

                        <td>{{ $producto->precio }} Bs</td>
                        <td>{{ $producto->stock }}</td>

                        <td>
                            <iframe height="130" width="150" scrolling="no" src="{{$producto->imagen}}" frameBorder="0"></iframe>
                        </td>

                        {!! Form::open(['route' => ['admin.detalle_pedidos.storeP', $producto->id], 'autocomplete' => 'off']) !!}

                        <td>
                            {!! Form::text('cantidad', null, ['class' => 'form-control', 'placeholder' => 'Cantidad']) !!}
                            @error('cantidad')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror

                        </td>

                        <td>
                            <input style=" width: 50px;" type="text" class="form-control" name="idpedido" id="idpedido"
                                value="{{ $pedido->id }}" readonly>

                            <button class="btn btn-primary" type="submit" rel="tooltip">Agregar</button>

                        </td>
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </tbody>
        </table>
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
