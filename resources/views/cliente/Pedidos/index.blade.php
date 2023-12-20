@extends('layouts.cliente')

@section('title', 'Lista Pedidos')

@section('content_header')
    <a class="btn btn-success btn-sm float-right" href="{{ route('admin.pedidos.create') }}">
        <i class="material-icons fa fa-plus"> Nuevo Pedido </i>
    </a>
    <h1>Lista de Pedidos</h1>
    <div class="row">
        <div class="form-group col-md-1">
            <p>Reportes en: </p>
        </div>

        <div class="form-group col-md-2">
            <a class="btn btn-primary btn-sm float-left" href="{{ route('admin.PDF.usuarios') }}">
                <i class="fa fa-download"></i>
                PDF
            </a>
        </div>

    </div>

@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong> {{ session('info') }}</strong>
        </div>
    @endif
    @if (session('info2'))
        <div class="alert alert-danger">
            <strong> {{ session('info2') }}</strong>
        </div>
    @endif
    <br>
    <br>
    <br>
    <br>
    <h1 class="text-center">LISTA DE MIS PEDIDOS</h1>

    <div class="card-body">
        <table class="table table-striped" id="pedidos">
            <thead>
                <tr class="bg-dark text-center text-white">
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Direccion</th>
                    <th>Fecha de Pedido</th>
                    <th>Total</th>
                    <th>Entrega</th>l
                    <th>Pago</th>
                    <th>Productos</th>
                    <th>Detalle</th>
                    <th>Eliminar</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        @foreach ($clientes as $cliente)
                            @if ($cliente->id == $pedido->cliente_id)
                                <td>{{ $cliente->name }}</td>
                            @endif
                        @endforeach

                        <td>{{ $pedido->direccion }}</td>


                        <td>{{ $pedido->fecha_pedido }}</td>
                        <td>{{ $pedido->total }}</td>
                        <td>
                            @if ($pedido->estado == 'En espera')
                                <button class="btn btn-warning btn-sm" type="" rel="tooltip">
                                    {{ $pedido->estado }}
                                </button>
                            @endif

                            @if ($pedido->estado == 'Entregado')
                                <button class="btn btn-success btn-sm" type="" rel="tooltip">
                                    {{ $pedido->estado }}
                                </button>
                            @endif
                        </td>


                        <td>

                            @if ($pedido->estado_pago == 'Impagado')
                                <button class="btn btn-dark btn-sm btnGenerarQr" url="{{ route('admin.generarQr') }}"
                                    value="{{ $pedido->id }}">
                                    <i class="fa fa-qrcode"> Qr</i></button>
                            @endif
                            @if ($pedido->estado_pago == 'Pagado')
                                <a class="btn btn-dark btn-sm"
                                    href="{{ route('cliente.PDF.FacturaCliente', $pedido->id) }}">
                                    <i class="fa fa-print"> Factura</i>
                                </a>
                            @endif

                        </td>
                        <td width="10px">
                            @if ($pedido->estado_pago == 'Impagado')
                                <a class="btn btn-info" href="{{ route('cliente.pedidos.indexP', $pedido->id) }}">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            @endif           
                        </td>

                        <td width="10px">

                            <a class="btn btn-secondary" href="{{ route('cliente.pedidos.show', $pedido->id) }}">
                                <i class="fas fa-file"></i>
                            </a>
                        </td>

                        <td width="10px">
                            <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                                onsubmit="return confirm('¿Estas seguro de eliminar este a {{ $pedido->id }}?')">
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg para un modal grande -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="msmModal" class="modal-title text-center w-100">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <img id="imagenModal" src="" class="img-fluid" alt="Imagen Grande"
                        style="max-width: 100%; max-height: 400px;">
                    <!-- Ajusta el tamaño según tus necesidades -->
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pedidos').DataTable();
        });
    </script>
    <script>
        function generarQr(id, url) {
            // Datos que deseas enviar en la solicitud
            var datos = {
                pedido_id: id,
            };

            // Realizar la solicitud AJAX POST

            console.log(datos)
            $.ajax({
                type: "POST",
                url: url, // Reemplaza con la URL de tu API
                data: datos,
                success: function(respuesta) {
                    console.log("Solicitud exitosa:", respuesta);
                    if (respuesta['error'] != null) {
                        $('#msmModal').text(respuesta['error']);
                        $('#imagenModal').attr('src',
                            'https://img.freepik.com/vector-premium/ilustracion-llorar-codigo-qr-lindo-bebe_152558-82202.jpg?w=2000'
                        );
                        $('#exampleModal').modal('show');
                    } else {
                        if (respuesta['img'] != null) {
                            $('#imagenModal').attr('src', respuesta['img']);
                            $('#msmModal').text('PAGUE CON QR !!!');
                            $('#exampleModal').modal('show');
                        }
                    }
                },
                error: function(error) {
                    console.error("Error en la solicitud:", error);

                }
            });
        }

        $(document).ready(function() {
            $(".btnGenerarQr").on("click", function() {
                var id = $(this).val();

                var url = $(this).attr("url");
                $('#msmModal').text('Generando QR. Por favor, espera...');
                $('#imagenModal').attr('src', 'https://complemedical.s3.amazonaws.com/generando.gif');
                $('#exampleModal').modal('show');
                generarQr(id, url);
            });
        });
    </script>
    <script>
        console.log('hi!')
    </script>
@stop


