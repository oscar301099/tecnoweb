@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<a class="btn btn-success btn-sm float-right" href="{{route('admin.productos.create')}}">
    <i class="material-icons fa fa-plus"> Nuevo Producto </i>
</a>
<h1>Lista de Productos</h1>

@stop

@section('content')

    @if(session('info'))
            <div class="alert alert-success">
                <strong> {{session('info')}}</strong>
            </div>
    @endif

    <div class="card-body">
        <table class="table table-striped" id="productos">
            <thead>
                <tr>
                    <th style=" width: 10px;">ID</th>
                    <th style=" width: 50px;">Nombre</th>
                    <th style=" width: 100px;">categoria</th>
                    <th style=" width: 100px;">Marca</th>
                    <th style=" width: 50px;">Proveedor</th>

                </tr>
            </thead> 

            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>

                        <td>
                            @foreach($categorias as $categoria)
                                @if($producto->categoria_id == $categoria->id)
                                {{$categoria->nombre}}
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @foreach($marcas as $marca)
                                @if($producto->marca_id == $marca->id)
                                {{$marca->nombre}}
                                @endif
                            @endforeach
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
     $('#productos').DataTable();
    } );
</script>
@stop
