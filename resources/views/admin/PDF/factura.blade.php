<!DOCTYPE html>
<html>

<head>

    <h1>
        <center>Factura</center>
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
                <th scope="row">NIT: </th>
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

            <tr>
                <th scope="row">Cliente: </th>
                @if ($pedido->id == $factura->pedido_id)
                    @foreach ($clientes as $cliente)
                        @if ($cliente->id == $pedido->cliente_id)
                            <td class="table-warning">{{ $cliente->name }}</td>
                        @endif
                    @endforeach
                @endif
                <th scope="row">Nro Pedido: </th>
                <td class="table-warning">{{ $pedido->id }}</td>
            </tr>

            <tr>
                <th scope="row">Nro Factura: </th>
                <td class="table-warning">{{ $factura->id }}</td>
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
                    <th scope="col">Nro</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Totales</th>
                </tr>
            </thead>

            <tbody>

                @php
                    $i = 1;
                @endphp
                @foreach ($detalles as $detalle)
                    <tr>
                        <th>{{ $i++ }}</th>
                        @foreach ($productos as $producto)
                            @if ($producto->id == $detalle->producto_id)
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->precio }}</td>
                            @endif
                        @endforeach
                        <td>{{ $detalle->cantidad }}</td>
                        <td class="table-success">{{ $detalle->precio }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"></td>
                    <td class="table-primary">SubTotal:</td>
                    <td class="table-primary">{{ $factura->pago_neto }}</td>
                </tr>

                {{-- <tr>
                    <td colspan="3"></td>
                    <td class="table-info">Promocion:</td>
                    @if ($dato)
                        <td class="table-info"> - </td>
                    @else
                        @php
                            $porc = $promocion->porcentaje / 100;
                            $monto = $pedido->total * $porc;
                        @endphp
                        <td class="table-info">{{ $monto }} => {{ $porc }}</td>
                    @endif
                </tr> --}}

                <tr>
                    <td colspan="3"></td>
                    <th class="bg-warning">TOTAL:</th>
                    <td class="table-warning">{{ $factura->pago_total }}</td>
                </tr>

            </tbody>

        </table>
    </div>
</body>

</html>
