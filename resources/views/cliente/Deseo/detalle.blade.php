@extends('layouts.cliente')

@section('title', 'Detalles de Deseo')


@section('content_header')
    <a class="btn btn-danger float-left" href="{{ route('admin.pedidos.index') }}">
        <i class="fa fa-arrow-left"> Atras</i>
    </a>
    <h1 class="float-right">
        <strong>deseo: </strong> {{ $deseo->id }} <----------> <strong>Cliente: </strong> {{ $cliente->name }}
    </h1>


@stop

@section('content')
    <br>
    @if (session('info'))
        <div class="alert alert-success">
            <strong> {{ session('info') }}</strong>
        </div>
    @endif
    <br>
    <br>
    <br>
    <br>
    <h1 class="text-center">MI LISTA DE DESEOS</h1>
    <div class="text-center mb-3">

        {{-- <a href="{{ route('cliente.pedidos.createC') }}" class="btn btn-primary">Agregar a Carrito</a> --}}
        {{-- {!! Form::open(['route' => 'cliente.pedidos.createC', 'autocomplete' => 'off']) !!}
        <button class="btn btn-primary" type="submit" rel="tooltip">
            <i class="material-icons fa fa-save"> Agregar a Carrito</i>
        </button>
        {!! Form::close() !!} --}}



        {!! Form::open(['route' => 'cliente.pedidos.createC', 'autocomplete' => 'off']) !!}
        <!-- Otros campos del formulario -->

        <!-- Campo para la dirección IP -->
        <input type="hidden" name="direccion_ip" value="{{ request()->ip() }}">

        <button class="btn btn-primary" type="submit" rel="tooltip">
            <i class="fa fa-cart-plus" aria-hidden="true"> Agregar todo a Carrito</i>
        </button>
        {!! Form::close() !!}




    </div>

    <div class="card-body">
        <table class="table table-striped" id="detalle">
            <thead>
                <tr>
                    <th>ID Deseo</th>
                    <th>Producto</th>
                    <th>Precio Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Agregar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->id }}</td>
                        @foreach ($productos as $producto)
                            @if ($producto->id == $detalle->producto_id)
                                <td>{{ $producto->nombre }}</td>
                            @endif
                        @endforeach

                        @foreach ($productos as $producto)
                            @if ($producto->id == $detalle->producto_id)
                                <td>{{ $producto->precio }}</td>
                            @endif
                        @endforeach
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ $detalle->precio }}</td>

                        <td width="10px">
                            <form action="{{ route('cliente.pedidos.createCID', $detalle->id) }}" method="POST">
                                @csrf
                                {{-- @method('PUT') --}}

                                <!-- Campo para la dirección IP -->
                                <input type="hidden" name="direccion_ip" value="{{ request()->ip() }}">

                                <button class="btn btn-outline-warning" type="" rel="tooltip">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>

                        <td width="10px">
                            <form action="{{ route('cliente.pedidos.DetalleDestroyC', $detalle->id) }}" method="POST"
                                onsubmit="return confirm('¿Estas seguro de eliminar este a {{ $detalle->id }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="" rel="tooltip">
                                    <i class="material-icons fa fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#detalle').DataTable();
        });
    </script>
    <script>
        console.log('hi!')
    </script>
@stop
