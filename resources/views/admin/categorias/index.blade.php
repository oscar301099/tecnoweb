@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
<a class="btn btn-success btn-sm float-right" href="{{route('admin.categorias.create')}}">
    <i class="material-icons fa fa-plus"> Nueva Categoria </i>
</a>
<h1>Lista de Categorias</h1>
@stop
@section('content')
    @if(session('info'))
            <div class="alert alert-success">
                <strong> {{session('info')}}</strong>
            </div>
    @endif
    <div class="card-body">
        <table class="table table-striped" id="categorias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead> 
            <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nombre }}</td>
                        <td width="10px">
                                <a class="btn btn-outline-primary" href="{{route('admin.categorias.edit', $categoria)}}">
                                    <i class="material-icons fa fa-pen"></i>
                                </a>
                        </td>    
                        <td width="10px">
                                <form action="{{route('admin.categorias.destroy', $categoria)}}" method="POST" onsubmit="return confirm('¿Estas seguro de eliminar la Categoria:  {{$categoria->nombre}} ?')">
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
     $('#categorias').DataTable();
    } );
</script>
@stop

