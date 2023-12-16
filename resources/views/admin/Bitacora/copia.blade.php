@extends('adminlte::page')

@section('title', 'TienditaSI2')

@section('content_header')
@stop




@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h2><b>Busqueda Dinamica para reportes de Bitácora</b>
                <h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <select name="select" id="select" class="form-control ">
                        <option value=""> -- Seleccione -- </option>
                        <option value="1">Usuario</option>
                        <option value="2">Accion</option>
                        <option value="3">Tabla</option>
                        <option value="4">ID Afectado</option>
                        <option value="5">Fecha - Hora</option>
                        <option value="6">Direccion IP</option>
                    </select>
                </div>

                <div id="pai" class="form-group col-md-6">

                    <div id="1">
                        <label for="">Busqueda por Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario">
                        <button type="button" onclick="" class="btn btn-primary float-right my-2">
                            <i class="material-icons fa fa-search"> Buscar</i>
                        </button>

                    </div>
                    <div id="2">
                        <label for="">Busqueda por Accion:</label>
                        <input type="text" class="form-control" name="accion" id="accion">
                    </div>
                    <div id="3">
                        <label for="">Busqueda por Tabla:</label>
                        <input type="text" class="form-control" name="tabla" id="tabla">
                    </div>
                    <div id="4">
                        <label for="">Busqueda por ID Afectado:</label>
                        <input type="text" class="form-control" name="afectado" id="afectado">
                    </div>
                    <div id="5">
                        <label for="">Busqueda por Fecha:</label>
                        <input type="text" class="form-control" name="fecha_h" id="fecha_h">
                    </div>
                    <div id="6">
                        <label for="">Busqueda por IP:</label>
                        <input type="text" class="form-control" name="ip" id="ip">
                    </div>
                </div>

            </div>
        </div>

        <div class="input-group mb-3 col-md-6">
            <input type="text" class="form-control" placeholder="Ingrese Datos" id="texto">
            <span class="input-group-text" id="basic-addon2">Buscar</span>
          </div>


        <br>
        <br>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="bitacora" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Acción</th>
                            <th scope="col">Tabla</th>
                            <th scope="col">ID Afectado</th>
                            <th scope="col">Fecha-Hora</th>
                            <th scope="col">Dirección IP</th>
    
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($actividades as $actividad)
                            <tr>
                                <td>{{ $actividad->id }}</td>
                                <?php $username = DB::table('Users')
                                    ->where('id', $actividad->id_user)
                                    ->value('name');
                                ?>
                                <td>{{ $username }}</td>
                                <td>{{ decrypt($actividad->accion) }}</td>
                                <td>{{ decrypt($actividad->apartado) }}</td>
                                <td>{{ decrypt($actividad->afectado) }}</td>
                                <td>{{ decrypt($actividad->fecha_h) }}</td>
                                <td>{{ decrypt($actividad->ip) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>


@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <style>
        #pai div {
            display: none;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bitacora').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#select').on('change', function() {
                var selectValor = '#' + $(this).val();
                $('#pai').children('div').hide();
                $('#pai').children(selectValor).show();
            });
        });

        window.addEventListener("load", function(){
            document.getElementById("texto").addEventListener("keyup", function(){
                console.log(document.getElementById("texto").value)
            })
        })
    </script>
@stop
