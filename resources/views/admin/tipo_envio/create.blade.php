@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1>Crear nuevo Tipo de Envio</h1>

@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                {!! Form::open(['route' => 'admin.tipo_envios.store', 'autocomplete' => 'off']) !!}

                        <div class="form-group">
                        {!! Form::label('nombre','Nombre') !!}
                        {!! Form::text('nombre',null,['class' => 'form-control', 'placeholder' => 'Ingrese el Nombre del tipo de envio']) !!}

                        @error('nombre')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        

                        </div>

                        <div class="from-group">
                        {!! Form::label('descripcion','Descripcion') !!}
                        {!! Form::text('descripcion',null,['class' => 'form-control', 'placeholder' => 'Ingrese la descripcion del tipo de envio']) !!}

                        @error('descripcion')
                        <strong class="text-danger">{{ $message }}</strong>               
                        @enderror
                        
                        </div>
                        
                      
                        <br>
                                                                  
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" rel="tooltip">
                                <i class="material-icons fa fa-save"> Crear Tipo de envio</i>
                            </button>             
                        </div>
                        

                    {!! Form::close() !!}
                    <div class="form-group">
                        <a class="btn btn-danger" href="{{route('admin.tipo_envios.index')}}">
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
