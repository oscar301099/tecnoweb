<!DOCTYPE html>
<html>

<head>

    <h1>
        <center>LISTADO DE USUARIOS</center>
    </h1>
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Fecha de impresion:</th>
                <td>{{$date}}</td>
                <th scope="row">Razon Social: </th>
                <td>{{$configuracion->razon_social}}</td>
            </tr>

            <tr>
                <th scope="row">Factura:  </th>
                <td>{{$configuracion->factura}}</td>
                <th scope="row">E-mail: </th>
                <td>{{$configuracion->email}}</td>
            </tr>

            <tr>
                <th scope="row">Telefono: </th>
                <td>{{$configuracion->telefono}}</td>
                <th scope="row">Direccion: </th>
                <td>{{$configuracion->direccion}}</td>
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
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->tipo }}</td>
                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</body>

</html>
