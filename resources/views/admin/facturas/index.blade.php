@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <a class="btn btn-success btn-sm float-right" href="{{ route('admin.facturas.create') }}">
        <i class="material-icons fa fa-plus"> Nuevo Factura </i>
    </a>
    <h1>Lista de Facturas</h1>
    <div class="row">
        <div class="form-group col-md-1">
            <p>Reportes en: </p>
        </div>

        <div class="form-group col-md-2">
            <a class="btn btn-primary btn-sm float-left" href="{{ route('admin.PDF.clientes') }}">
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

    <div class="card-body">
        <table class="table table-striped" id="users">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nit</th>
                    <th>Nro Pedido</th>
                    <th>Cliente</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Imprimir</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($facturas as $factura)
                    <tr>
                        <td>{{ $factura->id }}</td>
                        <td>{{ $factura->nit }}</td>
                        <td>{{ $factura->pedido_id }}</td>
                        @foreach ($pedidos as $pedido)
                            @if ($pedido->id == $factura->pedido_id)
                                @foreach ($clientes as $cliente)
                                    @if ($cliente->id == $pedido->cliente_id)
                                        <td>{{ $cliente->name }}</td>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                            <td>{{ $factura->pago_neto }}</td>
                            <td>{{ $factura->pago_total }}</td>

                            <td width="10px">
                                <a class="btn btn-outline-info"
                                    href="{{ route('admin.PDF.factura', $factura->id) }}">
                                    <i class="material-icons fa fa-file-pdf"></i>
                                </a>
                            </td>


                            <td width="10px">
                                <form action="{{ route('admin.facturas.destroy', $factura->id) }}" method="POST"
                                    onsubmit="return confirm('¿Estas seguro de eliminar La factura Nro: {{ $factura->id }}?')">
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
            $('#users').DataTable();
        });
    </script>
@stop
