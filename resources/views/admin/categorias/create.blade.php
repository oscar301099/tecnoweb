@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1 class="text-center">Registar nueva Categoria</h1>

@stop

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                {!! Form::open(['route' => 'admin.categorias.store', 'autocomplete' => 'off']) !!}

                        <div class="form-group">
                            {!! Form::label('nombre','Nombre: ') !!}
                            {!! Form::text('nombre',null,['class' => 'form-control', 'placeholder' => 'Ingrese el Nombre de la Categoria']) !!}
                       
                            @error('nombre')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                                                                  
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" rel="tooltip">
                                <i class="material-icons fa fa-save"> Registrar Nueva Categoria</i>
                            </button>          
                        </div>
                        

                    {!! Form::close() !!}

                    <div class="form-group">
                        <a class="btn btn-danger" href="{{route('admin.categorias.index')}}">
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