@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
    <a class="btn btn-success btn-sm float-right" href="{{ route('admin.pedidos.create') }}">
        <i class="material-icons fa fa-plus"> Nuevo Pedido </i>
    </a>
    <h1>Lista de Pedidos</h1>
    <div class="row">
        <div class="form-group col-md-1">
            <p>Reportes en: </p>
        </div>

        <div class="form-group col-md-2">
            <a class="btn btn-primary btn-sm float-left" href="{{ route('admin.PDF.usuarios') }}">
                <i class="fa fa-download"></i>
                PDF
            </a>
        </div>

    </div>

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
    

    <div class="card-body">
        <table class="table table-striped" id="pedidos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Direccion</th>
                    <th>Fecha de Pedido</th>
                    <th>Total</th>
                    <th>Entrega</th>
                    <th>Pago</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        @foreach ($clientes as $cliente)
                            @if ($cliente->id == $pedido->cliente_id)
                                <td>{{ $cliente->name }}</td>
                            @endif
                        @endforeach

                        @foreach ($clientes as $cliente)
                            @if ($cliente->id == $pedido->cliente_id)
                                <td>{{ $cliente->direccion }}</td>
                            @endif
                        @endforeach

                        <td>{{ $pedido->fecha_pedido }}</td>
                        <td>{{ $pedido->total }}</td>
                        <td>
                            @if ($pedido->estado == 'En espera')
                                <form action="{{ route('admin.pedidos.entregado', $pedido->id) }}" method="GET"
                                    onsubmit="return confirm('¿Se ha entregado el pedido: {{ $pedido->id }}?')">
                                    @csrf
                                    <button class="btn btn-warning btn-sm" type="" rel="tooltip">
                                        {{ $pedido->estado }}
                                    </button>
                                </form>
                            @endif
                            @if ($pedido->estado == 'Entregado')
                                <form action="{{ route('admin.pedidos.espera', $pedido->id) }}" method="GET"
                                    onsubmit="return confirm('¿Cambiar el estado del pedido: {{ $pedido->id }}?')">
                                    @csrf
                                    <button class="btn btn-success btn-sm" type="" rel="tooltip">
                                        {{ $pedido->estado }}
                                    </button>
                                </form>
                            @endif
                        </td>


                        <td>
                            @if ($pedido->estado_pago == 'Impagado')
                                <form action="{{ route('admin.pedidos.CreateFactura', $pedido->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro de confirmar Pago del Pedido: {{ $pedido->id }}?')">
                                    @csrf
                                    <button class="btn btn-warning btn-sm" type="" rel="tooltip">
                                        {{ $pedido->estado_pago }}
                                    </button>
                                </form>
                            @endif
                            @if ($pedido->estado_pago == 'Pagado')
                            <form action="{{ route('admin.pedidos.DestroyFactura', $pedido->id) }}" method="POST"
                                onsubmit="return confirm('¿Seguro de Cancelar el Pago del Pedido: {{ $pedido->id }}?')">
                                @csrf
                                <button class="btn btn-success btn-sm" type="" rel="tooltip">
                                    {{ $pedido->estado_pago }}
                                </button>
                            </form>
                            @endif
                        </td>
                        <td width="10px">
                            <a class="btn btn-info" href="{{ route('admin.detalle_pedidos.indexP', $pedido->id) }}">
                                Productos
                            </a>
                        </td>

                        <td width="10px">
                            <a class="btn btn-secondary" href="{{ route('admin.detalle_pedidos.show', $pedido->id) }}">
                                Detalle
                            </a>
                        </td>

                        <td width="10px">
                            <a class="btn btn-outline-primary" href="{{ route('admin.pedidos.edit', $pedido->id) }}">
                                <i class="material-icons fa fa-pen"></i>
                            </a>
                        </td>

                        <td width="10px">
                            <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                                onsubmit="return confirm('¿Estas seguro de eliminar este a {{ $pedido->id }}?')">
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
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pedidos').DataTable();
        });
    </script>
    <script>
        console.log('hi!')
    </script>
@stop
