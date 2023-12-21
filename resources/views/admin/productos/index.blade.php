@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
    <div class="form-group col-md-1">
        <p>Reportes en: </p>
    </div>

    <a class="btn btn-success btn-sm float-right" href="{{ route('admin.productos.create') }}">

        <i class="material-icons fa fa-plus"> Nuevo Producto </i>
    </a>
    <h1>Lista de Productos</h1>
@stop
@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong> {{ session('info') }}</strong>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-striped" id="productos">
            <thead>
                <tr>
                    <th style=" width: 10px;">ID</th>
                    <th style=" width: 50px;">Nombre</th>
                    <th style=" width: 200px;">Descripcion</th>
                    <th style=" width: 100px;">categoria</th>
                    <th style=" width: 100px;">Marca</th>
                    <th style=" width: 100px;">Precio</th>
                    <th style=" width: 100px;">Stock</th>
                    <th style=" width: 100px;">Imagen</th>
                    <th style=" width: 10px;">Operaiones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>

                        <td>
                            @foreach ($categorias as $categoria)
                                @if ($producto->categoria_id == $categoria->id)
                                    {{ $categoria->nombre }}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($marcas as $marca)
                                @if ($producto->marca_id == $marca->id)
                                    {{ $marca->nombre }}
                                @endif
                            @endforeach
                        </td>


                        <td>{{ $producto->precio }} Bs</td>
                        <td>{{ $producto->stock }}</td>

                        <td>
                            <iframe height="130" width="150" scrolling="no" src="{{ $producto->imagen }}"
                                frameBorder="0"></iframe>
                        </td>

                        <td width="10px">
                            <a class="btn btn-outline-secondary" href="{{ route('admin.productos.show', $producto) }}">
                                <i class="material-icons fa fa-eye"></i>
                            </a>

                            <a class="btn btn-outline-primary" href="{{ route('admin.productos.edit', $producto) }}">
                                <i class="material-icons fa fa-pen"></i>
                            </a>

                            <form action="{{ route('admin.productos.show', $producto) }}" method="POST"
                                onsubmit="return confirm('¿Estas seguro de eliminar el Producto:  {{ $producto->nombre }} ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger my-1" type="" rel="tooltip">
                                    <i class="material-icons fa fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productos').DataTable();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const botonCambiarModo = document.getElementById('cambiarModo');
            let modoActual = localStorage.getItem('modo') || 'dia';
            aplicarModo(modoActual);
            botonCambiarModo.addEventListener('click', function() {
                modoActual = modoActual === 'dia' ? 'noche' : 'dia';
                localStorage.setItem('modo', modoActual);
                aplicarModo(modoActual);
            });

            function aplicarModo(modo) {
                //    document.body.style.backgroundImage = `url('${modo === 'dia' ? 'URL_DE_TU_IMAGEN_DIURNA' : 'URL_DE_TU_IMAGEN_NOCTURNA'}')`;
                document.body.style.filter = `brightness(${modo === 'dia' ? '100%' : '70%'})`;
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const botonCambiarModo = document.getElementById('cambiarModo');
            const botonAumentarLetra = document.getElementById('aumentarLetra');
            const botonDisminuirLetra = document.getElementById('disminuirLetra');
            let contrasteActual = localStorage.getItem('contraste') || 'normal';
            let tamanioLetraActual = localStorage.getItem('tamanioLetra') || '16px';

            aplicarContraste(contrasteActual);
            aplicarTamanioLetra(tamanioLetraActual);

            botonCambiarModo.addEventListener('click', function() {
                contrasteActual = contrasteActual === 'normal' ? 'alto' : 'normal';
                localStorage.setItem('contraste', contrasteActual);
                aplicarContraste(contrasteActual);
            });

            botonAumentarLetra.addEventListener('click', function() {
                tamanioLetraActual = aumentarTamanioLetra(tamanioLetraActual);
                localStorage.setItem('tamanioLetra', tamanioLetraActual);
                aplicarTamanioLetra(tamanioLetraActual);
            });

            botonDisminuirLetra.addEventListener('click', function() {
                tamanioLetraActual = disminuirTamanioLetra(tamanioLetraActual);
                localStorage.setItem('tamanioLetra', tamanioLetraActual);
                aplicarTamanioLetra(tamanioLetraActual);
            });

            function aplicarContraste(contraste) {
                document.body.classList.toggle('alto-contraste', contraste === 'alto');
            }

            function aumentarTamanioLetra(tamanioActual) {
                const tamanioNumerico = parseInt(tamanioActual);
                return `${tamanioNumerico + 2}px`;
            }

            function disminuirTamanioLetra(tamanioActual) {
                const tamanioNumerico = parseInt(tamanioActual);
                return `${Math.max(tamanioNumerico - 2, 12)}px`;
            }

            function aplicarTamanioLetra(tamanio) {
                document.body.style.fontSize = tamanio;
            }
        });
    </script>
@stop
