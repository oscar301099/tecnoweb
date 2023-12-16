@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1 class="text-center">Datos Del Producto</h1>
@stop

@section('content')

@if(session('info'))
    <div class="alert alert-success">
        <strong> {{session('info')}}</strong>
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p class="h5">ID: </p>
                    <p class="form-control">{{$producto->id}}</p>

                    <p class="h5">Nombre: </p>
                    <p class="form-control">{{$producto->nombre}}</p>

                    <p class="h5">Descripcion: </p>
                    <p class="form-control">{{$producto->descripcion}}</p>

                    <p class="h5">Marca: </p>
                    @foreach($marcas as $marca)
                                    @if($producto->marca_id == $marca->id)
                                        <p class="form-control">{{$marca->nombre}}</p>
                                    @endif
                    @endforeach
                    

                    <p class="h5">Categoria: </p>
                    @foreach($categorias as $categoria)
       
                        @if($producto->categoria_id == $categoria->id)
                        <p class="form-control">{{$categoria->nombre}}</p>
                        @endif
                    
                    @endforeach
                    
                    <p class="h5">Precio: </p>
                    <p class="form-control">{{$producto->precio}}</p>

                    <p class="h5">Stock: </p>
                    <p class="form-control">{{$producto->stock}}</p>
                        
                    <p class="h5">Imagen: </p>
                    <iframe height="230" width="250" scrolling="no" src="{{$producto->imagen}}" frameBorder="0" class="mx-auto d-block border border-dark"></iframe> 

                </div>
                <div class="form-group col-md-4">
                    <a class="btn btn-danger" href="{{route('admin.productos.index')}}">
                        <i class="fa fa-arrow-left"> Atras</i>
                    </a>   
                </div>
                
            </div>
        </div>
    </div>
 </div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@livewireStyles
@stop

@section('js')
<script>console.log('hi!')</script>
@livewireScripts
@stop
