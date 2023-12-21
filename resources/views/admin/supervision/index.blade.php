@extends('adminlte::page')

@section('title', 'Tipo de Envios')

@section('content_header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Custom CSS (si tienes algún estilo personalizado) -->
    <style>
        /* Agrega tus estilos personalizados aquí */
    </style>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <h1>Lista de supervision</h1>

@stop


@section('content')
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mi Dashboard</a>
        <button id="cambiarModo" class=" hover:text-gray-300">Cambiar Modo</button>
                    <button id="aumentarLetra" class="hover:text-gray-300">Aumentar Letra</button>
                    <button id="disminuirLetra" class="hover:text-gray-300">Disminuir Letra</button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <!-- Contenido del dashboard -->
    <div class="container mt-4">
        <div class="row">


            <!-- Sección para el gráfico -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gráfico Bonito</h5>
                        <div id="apexchart"></div>
                    </div>
                </div>
            </div>

            <!-- Sección para el gráfico de líneas -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gráfico de Líneas</h5>
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>

            <!-- Sección para el gráfico de donas -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gráfico de Donas</h5>
                        <div id="donutChart"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ventas por Categoría</h5>
                        <div id="stackedBarChart"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Comparación de Métricas</h5>
                        <div id="radarChart"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>





    <!-- Bootstrap JS y Popper.js CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Font Awesome JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

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
            $('#supervision').DataTable();
        });
    </script>



    <script>
        // Datos de ejemplo para el gráfico
        var options = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Ventas',
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep'],
            },
            yaxis: {
                title: {
                    text: 'Ventas'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " mil";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apexchart"), options);

        chart.render();
    </script>

    <script>
        var lineOptions = {
            chart: {
                height: 350,
                type: 'line',
            },
            series: [{
                name: "Ventas",
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep']
            }
        };

        var lineChart = new ApexCharts(document.querySelector("#lineChart"), lineOptions);
        lineChart.render();
    </script>

    <script>
        var donutOptions = {
            chart: {
                height: 350,
                type: 'donut',
            },
            series: [30, 40, 35, 50, 49],
            labels: ['Producto A', 'Producto B', 'Producto C', 'Producto D', 'Producto E'],
            colors: ['#FF4560', '#008FFB', '#00E396', '#FEB019', '#775DD0'],
        };

        var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
        donutChart.render();
    </script>


    <script>
        var stackedBarOptions = {
            chart: {
                height: 350,
                type: 'bar',
                stacked: true,
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                },
            },
            series: [{
                name: 'Ventas',
                data: [30, 40, 35, 50, 49],
            }, {
                name: 'Devoluciones',
                data: [-5, -10, -15, -20, -15],
            }],
            xaxis: {
                categories: ['Producto A', 'Producto B', 'Producto C', 'Producto D', 'Producto E'],
            },
            colors: ['#008FFB', '#FF4560'],
        };

        var stackedBarChart = new ApexCharts(document.querySelector("#stackedBarChart"), stackedBarOptions);
        stackedBarChart.render();
    </script>

    <script>
        var radarOptions = {
            chart: {
                height: 350,
                type: 'radar',
            },
            series: [{
                name: 'Métricas',
                data: [80, 50, 30, 40, 60],
            }],
            labels: ['Visitantes', 'Conversiones', 'Ingresos', 'Retención', 'Satisfacción'],
        };

        var radarChart = new ApexCharts(document.querySelector("#radarChart"), radarOptions);
        radarChart.render();
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
                document.body.style.backgroundImage = `url('${modo === 'dia' ? 'URL_DE_TU_IMAGEN_DIURNA' : 'URL_DE_TU_IMAGEN_NOCTURNA'}')`;
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
