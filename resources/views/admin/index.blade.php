@extends('adminlte::page')

@section('title', 'Dueño')

@section('content_header')

@stop

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <br>
    <div class="card-body bg-danger text-white">
        <div class="container mx-auto flex flex-col md:flex-row my-auto md:my-36">
            <div class="flex flex-col w-full lg:w-2/5 p-8">
                <button id="cambiarModo" class="btn btn-info">Cambiar Modo</button>
                <br>
                <button id="aumentarLetra" class="btn btn-info">Aumentar Letra</button>
                <br>
                <button id="disminuirLetra" class="btn btn-info">Disminuir Letra</button>
                <p class="text-3xl md:text-5xl text-yellow-500 my-4 leading-relaxed md:leading-snug">Contactanos</p>
                <p class="font-sans text-sm md:text-lg my-2 md:my-4"><svg class="inline-block fill-current mr-2"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z" />
                    </svg>{{ $configuration->direccion }}</p>
                <p class="font-sans text-sm md:text-lg my-2 md:my-4"><svg class="inline-block fill-current mr-2"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M12 12.713l-11.985-9.713h23.971l-11.986 9.713zm-5.425-1.822l-6.575-5.329v12.501l6.575-7.172zm10.85 0l6.575 7.172v-12.501l-6.575 5.329zm-1.557 1.261l-3.868 3.135-3.868-3.135-8.11 8.848h23.956l-8.11-8.848z" />
                    </svg> {{ $configuration->email }}</p>

                <p class="font-sans text-sm md:text-lg my-2 md:my-4">Para Ayuda en linea dale click al siguiente numero:</p>
                <p class="font-sans text-sm md:text-lg my-2 md:my-4"><svg class="inline-block fill-current mr-2"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M20 22.621l-3.521-6.795c-.008.004-1.974.97-2.064 1.011-2.24 1.086-6.799-7.82-4.609-8.994l2.083-1.026-3.493-6.817-2.106 1.039c-7.202 3.755 4.233 25.982 11.6 22.615.121-.055 2.102-1.029 2.11-1.033z" />
                    </svg><a href="{{$configuration->whatsapp}}" target="_blank"><i
                            class="fa fab fa-whatsapp"></i> +591 {{ $configuration->telefono }}</a></p> <br> <br>
                <p class="font-sans text-sm md:text-lg my-2 md:my-4"> Gracias por elegirnos, quedate con nosotos!!
                </p>
            </div>
            <div class=" flex flex-col lg:w-3/5 justify-center w-full lg:-mt-12">
                <div class="container">
                    <div class="relative flex flex-col min-w-0 break-words w-full">
                        <div class="flex-auto p-5 lg:p-10">
                            <img src="https://assets-global.website-files.com/60d62401e092df5e99016f84/62bb4c2cb33c125eaaa67aba_1.%20Ventas%20en%20ecommerce%20para%20retail.jpg"
                                alt="contact image">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modoActual = localStorage.getItem('modo') || 'dia';
            aplicarModo(modoActual);

            // Agregar un controlador de eventos al botón
            const cambiarModoBtn = document.getElementById('cambiarModo');

            if (cambiarModoBtn) {
                cambiarModoBtn.addEventListener('click', function() {
                    // Cambiar el modo al hacer clic en el botón
                    const nuevoModo = localStorage.getItem('modo') === 'dia' ? 'noche' : 'dia';
                    aplicarModo(nuevoModo);
                    localStorage.setItem('modo', nuevoModo);
                });
            }
        });

        function aplicarModo(modo) {
            // Cambiar el filtro de brillo en el cuerpo
            document.body.style.filter = `brightness(${modo === 'dia' ? '100%' : '70%'})`;

            // Cambiar las clases de fondo y texto en la tarjeta si existe
            const tarjeta = document.getElementById('card-body');

            if (tarjeta) {
                if (modo === 'noche') {
                    tarjeta.style.backgroundColor = '#ffffff'; // Fondo blanco
                    tarjeta.style.color = '#000000'; // Texto negro
                } else {
                    tarjeta.style.backgroundColor = '#000000'; // Fondo negro
                    tarjeta.style.color = '#ffffff'; // Texto blanco
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const botonCambiarModo = document.getElementById('cambiarModo');
            const botonAumentarLetra = document.getElementById('aumentarLetra');
            const botonDisminuirLetra = document.getElementById('disminuirLetra');

            let contrasteActual = localStorage.getItem('contraste') || 'normal';
            let tamanioLetraActual = localStorage.getItem('tamanioLetra') || '16px';
            aplicarTamanioLetra(tamanioLetraActual);
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
@stop
