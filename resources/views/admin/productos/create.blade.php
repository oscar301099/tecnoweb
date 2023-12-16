@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
    <h1 class="text-center">Registar nuevo Producto</h1>

@stop

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        {!! Form::open(['route' => 'admin.productos.store', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data']) !!}

                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('nombre', 'Nombre: ') !!}
                                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Nombre del Producto']) !!}

                                @error('nombre')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Categoria: </label>
                                <select name=categoria_id id=categoria_id class="form-control">
                                    <option value="">-- Escoja una Categoria --</option>

                                    @foreach ($categoria as $categorias)
                                        <option value="{{ $categorias['id'] }}">{{ $categorias['nombre'] }}</option>
                                    @endforeach

                                </select>

                                @error('categoria_id')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Marca: </label>
                                <select name=marca_id id=marca_id class="form-control">
                                    <option value="">-- Escoja una Marca --</option>

                                    @foreach ($marca as $marcas)
                                        <option value="{{ $marcas['id'] }}">{{ $marcas['nombre'] }}</option>
                                    @endforeach

                                </select>

                                @error('marca_id')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('descripcion', 'Descripcion: ') !!}
                            {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la Descripcion del Producto']) !!}

                            @error('descripcion')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('precio', 'Precio: ') !!}
                                {!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Precio del Producto']) !!}

                                @error('precio')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('stock', 'Stock: ') !!}
                                {!! Form::text('stock', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Stock del Producto']) !!}

                                @error('stock')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="from-group col-md-12">
                                {!! Form::label('imagen', 'Imagen:') !!}
                                {!! Form::textarea('imagen', null, ['class' => 'form-control', 'rows' => '8']) !!}
                                <br>
                                @error('imagen')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>



                        <br>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" rel="tooltip">
                                <i class="material-icons fa fa-save"> Crear Nuevo Producto</i>
                            </button>
                        </div>


                        {!! Form::close() !!}

                        <div class="form-group">
                            <a class="btn btn-danger" href="{{ route('admin.productos.index') }}">
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
