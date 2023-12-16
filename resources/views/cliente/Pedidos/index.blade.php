@extends('layouts.cliente')

@section('title', 'Lista Pedidos')

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
    <br>
    <br>
    <br>
    <br>
    <h1 class="text-center">LISTA DE MIS PEDIDOS</h1>

    <div class="card-body">
        <table class="table table-striped" id="pedidos">
            <thead>
                <tr class="bg-dark text-center text-white">
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Direccion</th>
                    <th>Fecha de Pedido</th>
                    <th>Total</th>
                    <th>Entrega</th>
                    <th>Pago</th>
                    <th>Productos</th>
                    <th>Detalle</th>
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

                                <td>{{ $pedido->direccion }}</td>


                        <td>{{ $pedido->fecha_pedido }}</td>
                        <td>{{ $pedido->total }}</td>
                        <td>
                            @if ($pedido->estado == 'En espera')
                                <button class="btn btn-warning btn-sm" type="" rel="tooltip">
                                    {{ $pedido->estado }}
                                </button>
                            @endif

                            @if ($pedido->estado == 'Entregado')
                                <button class="btn btn-success btn-sm" type="" rel="tooltip">
                                    {{ $pedido->estado }}
                                </button>
                            @endif
                        </td>


                        <td>
                            @if ($pedido->estado_pago == 'Impagado')
                                <form action="{{ route('cliente.pedidos.CreateFactura', $pedido->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro de confirmar Pago del Pedido: {{ $pedido->id }}?')">
                                    @csrf
                                    <button class="btn btn-warning btn-sm" type="" rel="tooltip">
                                        {{ $pedido->estado_pago }}
                                    </button>
                                </form>
                            @endif
                            @if ($pedido->estado_pago == 'Pagado')
                                <a class="btn btn-dark btn-sm" href="{{ route('cliente.PDF.FacturaCliente', $pedido->id) }}">
                                    <i class="fa fa-print"> Factura</i>
                                </a>
                            @endif
                        </td>
                        <td width="10px">
                            <a class="btn btn-info" href="{{ route('cliente.pedidos.indexP', $pedido->id) }}">
                                <i class="fas fa-shopping-cart"></i>
                            </a>


                        </td>

                        <td width="10px">
                            <a class="btn btn-secondary" href="{{ route('cliente.pedidos.show', $pedido->id) }}">
                                <i class="fas fa-file"></i>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
