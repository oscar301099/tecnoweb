@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<a class="btn btn-success btn-sm float-right" href="{{route('admin.detalle_productos.create')}}">
    <i class="material-icons fa fa-plus"> Nueva compra </i>
</a>
<h1>Lista de Detalles de compra</h1>

@stop

@section('content')

    @if(session('info'))
            <div class="alert alert-success">
                <strong> {{session('info')}}</strong>
            </div>
    @endif

    <div class="card-body">
        <table class="table table-striped" id="detalle_productos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->id }}</td>

                        @foreach ($proveedor as $prov)
                            @if ($prov->id == $detalle->proveedor_id)
                                <td>{{ $prov->nombre }}</td>
                            @endif
                        @endforeach

                        @foreach ($producto as $prod)
                            @if ($prod->id == $detalle->producto_id)
                                <td>{{ $prod->nombre }}</td>
                            @endif
                        @endforeach

                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ $detalle->precio }}</td>

                        <td width="10px">
                            <a class="btn btn-outline-primary"
                                href="{{ route('admin.detalle_productos.edit', $detalle) }}">
                                <i class="material-icons fa fa-pen"></i>
                            </a>
                        </td>

                        <td width="10px">
                            <form action="{{ route('admin.detalle_productos.destroy', $detalle) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estas seguro de eliminar la detalle de compra:  {{ $detalle->id }} ?')">
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
     $('#detalle_productos').DataTable();
    } );
</script>
@stop
