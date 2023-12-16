<div>
    <div class="card">

        <div class="card-header">
            {!! Form::open(['class' => 'form-group col-md-6', 'route' => 'admin.PDF.bitacoras', 'autocomplete' => 'off', 'method' => 'get']) !!}
            <input type="text" wire:model="search" class="form-control" placeholder="Ingrese el Servicio" name="buscador"
                id="buscador">
            <br>

            <div class="row">
                <div class="form-group col-md-2">
                    <button class="btn btn-primary btn-sm float-left" type="submit" rel="tooltip">
                        <i class="material-icons fa fa-download"> PDF</i>
                    </button>
                </div>
                {!! Form::close() !!}
                {!! Form::open(['class' => 'form-group col-md-6', 'route' => 'admin.bitacora.textBitacora', 'autocomplete' => 'off', 'method' => 'get']) !!}
                <div class="form-group col-md-4">
                    <button class="btn btn-secondary btn-sm float-left" type="submit" rel="tooltip">
                        <i class="material-icons fa fa-download"> Text</i>
                    </button>
                </div>
                <br>
                <input type="text" class="form-control" placeholder="Ingrese el Servicio" name="buscador2"
                    id="buscador2" style="display:none">
                {!! Form::close() !!}

            </div>


        </div>


        @if ($bitacoras->count())


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
                        @foreach ($bitacoras as $actividad)
                            <tr>
                                <td>{{ $actividad->id }}</td>
                                <?php $user = DB::table('users')->where('id', $actividad->id_user)->first();
                                ?>
                                <td>{{ $user->name }}</td>
                                <td>{{ $actividad->accion }}</td>
                                <td>{{ $actividad->apartado }}</td>
                                <td>{{ $actividad->afectado }}</td>
                                <td>{{ $actividad->fecha_h }}</td>
                                <td>{{ $actividad->ip }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="card-footer d-flex justify-content-end">
                {{ $bitacoras->onEachSide(1)->links() }}
            </div>
        @else
            <div class="card-body">
                <strong> No hay Registros</strong>
            </div>

        @endif


    </div>
</div>



<script>
    document.getElementById("buscador").addEventListener('keyup', autoCompleteNew);

    function autoCompleteNew(e) {
        var value = $(this).val();
        $("#buscador2").val(value);
    }
</script>
