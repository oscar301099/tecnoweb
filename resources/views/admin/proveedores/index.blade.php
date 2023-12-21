@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')
<a class="btn btn-success btn-sm float-right" href="{{route('admin.proveedores.create')}}">
    <i class="material-icons fa fa-plus"> Nuevo Proveedor </i>
</a>
<h1>Lista de Proveedores</h1>
<button id="cambiarModo" class=" hover:text-gray-300">Cambiar Modo</button>
                    <button id="aumentarLetra" class="hover:text-gray-300">Aumentar Letra</button>
                    <button id="disminuirLetra" class="hover:text-gray-300">Disminuir Letra</button>
@stop

@section('content')

    @if(session('info'))
            <div class="alert alert-success">
                <strong> {{session('info')}}</strong>
            </div>
    @endif


    <div class="card-body">
        <table class="table table-striped" id="proveedor">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead> 

            <tbody>
                @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>{{ $proveedor->telefono }}</td>

                        <td width="10px">
                            <a class="btn btn-outline-secondary"  href="{{route('admin.proveedores.show', $proveedor->id)}}">
                                        <i class="material-icons fa fa-eye"></i>
                            </a>
                        </td>

                        <td width="10px">
                                <a class="btn btn-outline-primary" href="{{route('admin.proveedores.edit', $proveedor)}}">
                                    <i class="material-icons fa fa-pen"></i>
                                </a>
                        </td>    


                        <td width="10px">
                                <form action="{{route('admin.proveedores.destroy', $proveedor->id)}}" method="POST" onsubmit="return confirm('¿Estas seguro de eliminar la Proveedor:  {{$proveedor->nombre}} ?')">
                                 @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" type="" rel="tooltip">
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
     $('#proveedor').DataTable();
    } );
</script>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            const botonCambiarModo = document.getElementById('cambiarModo');
            let modoActual = localStorage.getItem('modo') || 'dia';
            aplicarModo(modoActual);
            botonCambiarModo.addEventListener('click', function () {
                modoActual = modoActual === 'dia' ? 'noche' : 'dia';
                localStorage.setItem('modo', modoActual);
                aplicarModo(modoActual);
            });

            function aplicarModo(modo) {
            //     document.body.style.backgroundImage = `url('${modo === 'dia' ? 'URL_DE_TU_IMAGEN_DIURNA' : 'URL_DE_TU_IMAGEN_NOCTURNA'}')`;
                document.body.style.filter = `brightness(${modo === 'dia' ? '100%' : '70%'})`;
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const botonCambiarModo = document.getElementById('cambiarModo');
            const botonAumentarLetra = document.getElementById('aumentarLetra');
            const botonDisminuirLetra = document.getElementById('disminuirLetra');
            let contrasteActual = localStorage.getItem('contraste') || 'normal';
            let tamanioLetraActual = localStorage.getItem('tamanioLetra') || '16px';

            aplicarContraste(contrasteActual);
            aplicarTamanioLetra(tamanioLetraActual);

            botonCambiarModo.addEventListener('click', function () {
                contrasteActual = contrasteActual === 'normal' ? 'alto' : 'normal';
                localStorage.setItem('contraste', contrasteActual);
                aplicarContraste(contrasteActual);
            });

            botonAumentarLetra.addEventListener('click', function () {
                tamanioLetraActual = aumentarTamanioLetra(tamanioLetraActual);
                localStorage.setItem('tamanioLetra', tamanioLetraActual);
                aplicarTamanioLetra(tamanioLetraActual);
            });

            botonDisminuirLetra.addEventListener('click', function () {
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
