@extends('adminlte::page')

@section('title', 'Tipo de Pagos')

@section('content_header')
<a class="btn btn-success btn-sm float-right" href="{{route('admin.tipo_pagos.create')}}">
    <i class="material-icons fa fa-plus"> Nuevo Tipo de Pago </i>
</a>
<h1>Lista de Tipos de Pago</h1>

@stop

@section('content')
    @if(session('info'))
        <div class="alert alert-success">
            <strong> {{session('info')}}</strong>
        </div>
        @endif
        <div class="card-body">
            <table class="table table-striped" id="tipos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead> 

                <tbody>
                    @foreach($tipos as $tipo)
                        <tr>
                            <td>{{$tipo->id}}</td>
                            <td>{{$tipo->nombre}}</td>
                            <td>{{$tipo->descripcion}}</td>


                            <td width="10px">
                                <a class="btn btn-outline-primary" href="{{route('admin.tipo_pagos.edit', $tipo)}}">
                                    <i class="material-icons fa fa-pen"></i>
                                </a>
                            </td>

                            <td width="10px">
                                <form action="{{ route('admin.tipo_pagos.destroy', $tipo->id )}}" method="POST" onsubmit="return confirm('¿Estas seguro de eliminar: {{$tipo->nombre}}?')">
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
     $('#tipos').DataTable();
    } );
</script>
@stop

