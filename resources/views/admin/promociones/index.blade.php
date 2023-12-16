@extends('adminlte::page')

@section('title', 'Tipo de Envios')

@section('content_header')
<a class="btn btn-success btn-sm float-right" href="{{route('admin.promociones.create')}}">
    <i class="material-icons fa fa-plus"> Nueva Promocion </i>
</a>
<h1>Lista de Promociones</h1>

@stop

@section('content')
    @if(session('info'))
        <div class="alert alert-success">
            <strong> {{session('info')}}</strong>
        </div>
        @endif


        <div class="card-body">
            <table class="table table-striped" id="promociones">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Porcentaje (%)</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead> 

                <tbody>
                    @foreach($promociones as $promocion)
                        <tr>
                            <td>{{$promocion->id}}</td>
                            <td>{{$promocion->nombre}}</td>
                            <td>{{$promocion->porcentaje}} %</td>


                            <td width="10px">
                                <a class="btn btn-outline-primary" href="{{route('admin.promociones.edit', $promocion)}}">
                                    <i class="material-icons fa fa-pen"></i>
                                </a>
                            </td>

                            <td width="10px">
                                <form action="{{ route('admin.promociones.destroy', $promocion->id )}}" method="POST" onsubmit="return confirm('¿Estas seguro de eliminar: {{$promocion->nombre}}?')">
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
     $('#promociones').DataTable();
    } );
</script>
@stop
