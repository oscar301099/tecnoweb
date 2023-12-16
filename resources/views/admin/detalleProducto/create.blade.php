@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1 class="text-center">Registar Nueva Compra</h1>

@stop

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                {!! Form::open(['route' => 'admin.detalle_productos.store', 'autocomplete' => 'off']) !!}

                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('proveedor','Proveedor: ') !!}
                        <select name=proveedor_id id=proveedor_id class="form-control" >
                            <option value="">-- Escoja Proveedor --</option>

                            @foreach($proveedores as $proveedor)
                            <option value="{{$proveedor['id']}}">{{$proveedor['nombre']}}</option>
                            @endforeach
                            
                        </select>

                        @error('proveedor_id')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('producto','Producto: ') !!}
                        <select name=producto_id id=producto_id class="form-control" >
                            <option value="">-- Escoja Producto --</option>

                            @foreach($productos as $producto)
                            <option value="{{$producto['id']}}">{{$producto['nombre']}}</option>
                            @endforeach
                            
                        </select>
                        @error('producto_id')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                        
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('precio','Precio de Compra: ') !!}
                        {!! Form::text('precio',null,['class' => 'form-control', 'placeholder' => 'Ingrese el Precio']) !!}
                   
                        @error('precio')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('cantidad','Cantidad Comprada: ') !!}
                        {!! Form::text('cantidad',null,['class' => 'form-control', 'placeholder' => 'Ingrese la Cantidad']) !!}
                   
                        @error('cantidad')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                                                                  
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" rel="tooltip">
                                <i class="material-icons fa fa-save"> Registrar Compra</i>
                            </button>          
                        </div>
                        

                    {!! Form::close() !!}

                    <div class="form-group">
                        <a class="btn btn-danger" href="{{route('admin.detalle_productos.index')}}">
                            <i class="fa fa-arrow-left"> Atras</i>
                        </a>   
                    </div>

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