@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<h1>Perfil</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h1 class="card-title">Administrador</h1>
    </div>

    <div class="card-body">

        <b>Id de Usuario:</b>            <p class="my-2">{{auth()->user()->id}}</p>
        <b>Nombre del Usuario: </b>      <p class="my-2">{{auth()->user()->name}}</p>
        <b>E-mail del Usuario: </b>      <p class="my-2">{{auth()->user()->email}}</p>
        <b>Contraseña del Usuario </b>   <p class="my-2">{{auth()->user()->password}}</p>
        <br></br>

           

            <button class="btn btn-sm  btn-danger" onclick="window.location=''">
             <i class="fa fa-align-left"></i>
                 Editar
            </button>

    </div>

</div>


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>console.log('hi!')</script>
@stop
