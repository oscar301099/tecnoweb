@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1>Crear nuevo Usuario</h1>

@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                {!! Form::open(['route' => 'admin.users.store', 'autocomplete' => 'off']) !!}

                        <div class="form-group">
                        {!! Form::label('name','Nombre') !!}
                        {!! Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Ingrese el Nombre del Usuario']) !!}

                        @error('name')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        

                        </div>

                        <div class="from-group">
                        {!! Form::label('email','E-mail') !!}
                        {!! Form::text('email',null,['class' => 'form-control', 'placeholder' => 'Ingrese el E-mail del Usuario']) !!}

                        @error('email')
                        <strong class="text-danger">{{ $message }}</strong>               
                        @enderror
                        
                        </div>
                        
                        <br>

                        <div class="from-group">
                            <label for="password" class="">Contraseña:</label>
                            <input type="password" class="form-control" name="password" placeholder="Ingrese su nueva contraseña" autofocus>        
    
                            @error('password')
                            <strong class="text-danger">{{ $message }}</strong>                       
                            @enderror

                        
                        </div>

                        <br>
                        @foreach($roles as $role)
                        <div>
                            <label for="">
                                {!!Form::checkbox('roles[]', $role->id, null,['class'=> 'mr-1'])!!}
                                {{$role->name}}
                            </label>
                        </div>
                        @endforeach

                        <br>
                                                                  
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" rel="tooltip">
                                <i class="material-icons fa fa-save"> Crear Nuevo Usuario</i>
                            </button>             
                        </div>
                        

                    {!! Form::close() !!}
                    <div class="form-group">
                        <a class="btn btn-danger" href="{{route('admin.users.index')}}">
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
