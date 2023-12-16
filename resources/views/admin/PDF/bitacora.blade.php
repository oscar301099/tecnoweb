<!DOCTYPE html>
<html>

<head>

    <h1>
        <center>Reporte de Bitacora</center>
    </h1>
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Fecha de impresion:</th>
                <td>{{ $date }}</td>
                <th scope="row">Razon Social: </th>
                <td>{{ $configuracion->razon_social }}</td>
            </tr>

            <tr>
                <th scope="row">Factura: </th>
                <td>{{ $configuracion->factura }}</td>
                <th scope="row">E-mail: </th>
                <td>{{ $configuracion->email }}</td>
            </tr>

            <tr>
                <th scope="row">Telefono: </th>
                <td>{{ $configuracion->telefono }}</td>
                <th scope="row">Direccion: </th>
                <td>{{ $configuracion->direccion }}</td>
            </tr>
        </tbody>
    </table>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>

    <div class="">
        <table class="table table-striped">
            <thead class="thead-dark">
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
                    <?php $username = DB::table('Users')
                        ->where('id', $actividad->id_user)
                        ->value('name');
                    ?>
                    <td>{{ $username }}</td>
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
</body>

</html>
