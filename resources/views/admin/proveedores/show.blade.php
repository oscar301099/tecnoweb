@extends('adminlte::page')

@section('title', 'Proveedor - Compra')

@section('content_header')

    <h1>Compras obtenidas de: << <strong>{{ $proveedor->nombre }} </strong>
            >></h1>
            <br>
    <div class="row">
        <div class="form-group col-md-1">
            <a class="btn btn-danger" href="{{route('admin.proveedores.index')}}">
                <i class="fa fa-arrow-left"> Atras</i>
            </a>   
        </div>
        

        <div class="form-group col-md-1">
            <p>Reportes en: </p>
        </div>

        <div class="form-group col-md-2">
            <a class="btn btn-primary btn-sm float-left" href="">
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

    <div>
        <div class="card">


            @if ($detalles->count())


                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Proveedor</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->id }}</td>
                                    <td>{{ $proveedor->nombre }}</td>
                                    @foreach ($producto as $prod)
                                        @if ($prod->id == $detalle->producto_id)
                                            <td>{{ $prod->nombre }}</td>
                                        @endif
                                    @endforeach
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>{{ $detalle->precio }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body">
                    <strong> No hay Registros</strong>
                </div>

            @endif


        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @livewireStyles
@stop

@section('js')
    <script>
        console.log('hi!')
    </script>
    @livewireScripts
@stop
