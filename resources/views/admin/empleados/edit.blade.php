@extends('adminlte::page')

@section('title', 'Registrar Cliente')

@section('content_header')
    <h1>Editar Empleado: {{$empleado->name}}</h1>

@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        {!! Form::model($empleado,['route' => ['admin.empleados.update', $empleado->id], 'method' => 'put', 'autocomplete' => 'off']) !!}

                        <div class="row">
                            <div class="form-group col-md-6">
                                {!! Form::label('name', 'Nombre') !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Nombre del Empleado']) !!}

                                @error('name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror


                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('telefono', 'Telefono') !!}
                                {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el telefono del Empleado']) !!}

                                @error('telefono')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-10">
                                {!! Form::label('direccion', 'Direccion') !!}
                                {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese La direccion del Empleado']) !!}

                                @error('direccion')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>



                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('ci', 'Celuda de Identidad') !!}
                                {!! Form::text('ci', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el carnet del Empleado']) !!}

                                @error('ci')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror


                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('cargo', 'Cargo') !!}
                                {!! Form::text('cargo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el cargo del Empleado']) !!}

                                @error('cargo')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror


                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('sueldo', 'Sueldo') !!}
                                {!! Form::text('sueldo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el sueldo del Empleado']) !!}

                                @error('sueldo')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror


                            </div>

                        </div>

                        <div class="row">


                            <div class="from-group col-md-6">
                                {!! Form::label('email', 'E-mail') !!}
                                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el E-mail del Usuario']) !!}

                                @error('email')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror

                            </div>

                            <div class="from-group col-md-6">
                                <label for="password" class="">Contraseña:</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Ingrese su nueva contraseña" autofocus>

                                @error('password')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror

                            </div>
                        </div>



                        <br>


                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" rel="tooltip">
                                <i class="material-icons fa fa-save"> Registrar Cliente</i>
                            </button>
                        </div>


                        {!! Form::close() !!}
                        <div class="form-group">
                            <a class="btn btn-danger" href="{{ route('admin.empleados.index') }}">
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
    <script>
        console.log('hi!')
    </script>
    @livewireScripts
@stop
