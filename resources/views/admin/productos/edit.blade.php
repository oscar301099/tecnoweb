@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
    <h1>Editar Producto</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong> {{ session('info') }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            {!! Form::model($producto, ['route' => ['admin.productos.update', $producto], 'method' => 'put', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data']) !!}

            <div class="row">
                <div class="form-group col-md-1">
                    <label for="id">ID:</label>
                    <input type="text" class="form-control" name="id" value="{{ $producto->id }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="nombre">Nombre:</label>

                    <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" autofocus required>
                    @error('nombre')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label for="categoria">Categoria:</label>
                    <select name=categoria_id id=categoria_id class="form-control">
                        @foreach ($categoria as $busqueda)
                            @if ($busqueda->id == $producto->categoria_id)
                                <option value="{{ $busqueda['id'] }}" readonly>{{ $busqueda['nombre'] }}</option>
                            @endif
                        @endforeach

                        <option value=""> -- Nueva Categoria --</option>

                        @foreach ($categoria as $categorias)
                            <option value="{{ $categorias['id'] }}" readonly>{{ $categorias['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="marca">Marca:</label>
                    <select name=marca_id id=marca_id class="form-control">
                        @foreach ($marca as $datos)
                            @if ($datos->id == $producto->marca_id)
                                <option value="{{ $datos['id'] }}" readonly>{{ $datos['nombre'] }}</option>
                            @endif
                        @endforeach

                        <option value=""> -- Nueva Marca --</option>

                        @foreach ($marca as $marcas)
                            <option value="{{ $marcas['id'] }}" readonly>{{ $marcas['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="descripcion">Descripcion</label>
                    <input type="text" class="form-control" name="descripcion" value="{{ $producto->descripcion }}"
                        autofocus required>
                    @error('descripcion')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>


                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="precio">Precio:</label>
                        <input type="text" class="form-control" name="precio" value="{{ $producto->precio }}" pattern="^(?!0\d*\.?\d*$)\d*(\.\d+)?$" title="Debe ser un número mayor que cero" autofocus required>
                        @error('precio')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="stock">stock:</label>
                        <input type="text" class="form-control" name="stock" value="{{ $producto->stock }}" pattern="^\d*\.?\d+$" title="Debe ser un número decimal mayor o igual a cero" autofocus required>
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

                <button class="btn btn-primary" type="submit" rel="tooltip">
                    <i class="material-icons fa fa-save"> Guardar</i>
                </button>
                {!! Form::close() !!}

                <br>
                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.productos.index') }}">
                        <i class="fa fa-arrow-left"> Atras</i>
                    </a>
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
