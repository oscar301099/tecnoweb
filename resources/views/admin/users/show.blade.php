@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1>Mostrar Datos Del Usuario</h1>
@stop

@section('content')

@if(session('info'))
    <div class="alert alert-success">
        <strong> {{session('info')}}</strong>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <p class="h5">ID: </p>
        <p class="form-control">{{$user->id}}</p>

        <p class="h5">Nombre: </p>
        <p class="form-control">{{$user->name}}</p>

        <p class="h5">E-mail: </p>
        <p class="form-control">{{$user->email}}</p>

        {!! Form::model($user,['route' => ['admin.users.update', $user], 'method' => 'put']) !!}
            @foreach($roles as $role)
                <div>
                    <label for="">
                        {!!Form::checkbox('roles[]', $role->id, null,['class'=> 'mr-1'])!!}
                        {{$role->name}}
                    </label>
                </div>
            @endforeach
        {!! Form::close() !!}

    </div>
</div>

<div class="form-group col-md-4">
    <a class="btn btn-danger" href="{{route('admin.users.index')}}">
        <i class="fa fa-arrow-left"> Atras</i>
    </a>   
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
