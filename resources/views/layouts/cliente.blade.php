<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $dato = DB::table('configurations')
        ->where('id', 1)
        ->first(); ?>
    <title>@yield('title') - {{ $dato->razon_social }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <!--Replace with your tailwind.css once created-->
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <!--Totally optional : -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"
        integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ secure_asset('js/modo.js') }}" defer></script>


</head>

<body class="leading-normal tracking-normal">
    <div class="main-content flex-1 bg-gray-100 border-black">
        <div class="w-full text-gray-700 bg-red-600 dark-mode:text-red-200 dark-mode:bg-red-800">
            <div x-data="{ open: false }"
                class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8 bg-red-600">
                <div class="p-4 flex flex-row items-center justify-between bg-red-600">

                    <a href="{{ route('home') }}"
                        class="text-2xl font-semibold tracking-widest text-white uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">{{ $dato->razon_social }}</a>
                </div>
                <nav :class="{ 'flex': open, 'hidden': !open }"
                    class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row bg-red-600">
                    <button id="cambiarModo" class=" hover:text-gray-300">Cambiar Modo</button>
                   
                    <button id="aumentarLetra" class="hover:text-gray-300">Aumentar Letra</button>
               
                    <button id="disminuirLetra" class="hover:text-gray-300">Disminuir Letra</button>
                    <button id="modoniños" class=" hover:text-gray-300">modo niños</button>
                    <button id="modojovenes" class=" hover:text-gray-300">modo joven</button>
                    <button id="normal" class=" hover:text-gray-300">modo adulto</button>
                    

                    <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 text-white hover:bg-white hover:text-black"
                    href="{{ route('cliente.deseo.showD') }}">Deseo </a>


                    <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 text-white hover:bg-white hover:text-black"
                    href="{{ route('cliente.carrito.showC') }}">Carrito </a>

                    <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 text-white hover:bg-white hover:text-black"
                        href="{{ route('cliente.pedidos.index') }}">Pedidos</a>


                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg text-white hover:bg-white hover:text-black md:w-auto md:inline md:mt-0 md:ml-4">
                            <span>{{ Auth::user()->name }}</span>
                            <svg fill="currentColor" viewBox="0 0 20 20"
                                :class="{ 'rotate-180': open, 'rotate-0': !open }"
                                class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                            <div class="px-2 py-2 bg-white border-black rounded-md shadow dark-mode:bg-gray-800">
                                <a class="block my-1 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                    href="{{ route('cliente.perfil') }}">Perfil</a>

                                <a class="block my-1 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                    href="{{ route('cliente.changePassword') }}">Cambiar Contraseña</a>

                                <a class=" font-semibold border-2 p-2 hover:bg-red-800 hover:text-white py-2 px-4 rounded-md text-sm no-underline hover:no-underline block"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                    <i class="fas fa-sign-out-alt fa-fw"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>


                </nav>
            </div>
        </div>
    </div>
    <div id="contenedorPrincipal" class="main-content flex-1 bg-gray-100 border-black">
        @yield('content')
        <div>
            <footer class="bg-red-600 border-t-2 border-black">
                <div class="max-w-screen-xl px-4 py-6 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
                    <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                        <div class="px-5 py-2">
                            <a href="#" class="text-base leading-6 text-white hover:text-gray-900">
                                About
                            </a>
                        </div>
                        <div class="px-5 py-2">
                            <a href="#" class="text-base leading-6 text-white hover:text-gray-900">
                                Blog
                            </a>
                        </div>
                        <div class="px-5 py-2">
                            <a href="#" class="text-base leading-6 text-white hover:text-gray-900">
                                Team
                            </a>
                        </div>
                        <div class="px-5 py-2">
                            <a href="#" class="text-base leading-6 text-white hover:text-gray-900">
                                Pricing
                            </a>
                        </div>
                        <div class="px-5 py-2">
                            <a href="#" class="text-base leading-6 text-white hover:text-gray-900">
                                Contact
                            </a>
                        </div>
                        <div class="px-5 py-2">
                            <a href="#" class="text-base leading-6 text-white hover:text-gray-900">
                                Terms
                            </a>
                        </div>
                    </nav>
                    <div class="flex justify-center mt-8 space-x-6">
                        <a href="#" class="text-white hover:text-gray-500">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-9 h-9" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-500">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-9 h-9" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-500">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-9 h-9" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                                </path>
                            </svg>
                        </a>

                    </div>
                    <p class="mt-8 text-base leading-6 text-center text-white">
                        © 2021 {{ $dato->razon_social }}, Inc. All rights reserved.
                    </p>
                </div>
            </footer>



            @yield('css')

            @yield('js')
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const botonModoNinos = document.getElementById('modoniños');
        const contenedorPrincipal = document.getElementById('contenedorPrincipal');

        const modoNinosActivated = localStorage.getItem('modoNinosActivated') === 'true';
        if (modoNinosActivated) {
            contenedorPrincipal.style.backgroundImage = 'url("/img/a.png")';
        }

        botonModoNinos.addEventListener('click', function () {
            const newState = !modoNinosActivated;
            localStorage.setItem('modoNinosActivated', newState);
            contenedorPrincipal.style.backgroundImage = newState ? 'url("/img/a.png")' : 'none';
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const botonModoJovenes = document.getElementById('modojovenes');
        const contenedorPrincipal = document.getElementById('contenedorPrincipal');

        const modoJovenesActivated = localStorage.getItem('modoJovenesActivated') === 'true';
        if (modoJovenesActivated) {
            contenedorPrincipal.style.backgroundImage = 'url("/img/b.jpeg")';
        }

        botonModoJovenes.addEventListener('click', function () {
            const newState = !modoJovenesActivated;
            localStorage.setItem('modoJovenesActivated', newState);
            contenedorPrincipal.style.backgroundImage = newState ? 'url("/img/b.jpeg")' : 'none';
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const botonModoNormal = document.getElementById('normal');
        const contenedorPrincipal = document.getElementById('contenedorPrincipal');

        botonModoNormal.addEventListener('click', function () {
            contenedorPrincipal.style.backgroundImage = 'none';
            localStorage.setItem('modoNinosActivated', 'false');
            localStorage.setItem('modoJovenesActivated', 'false');
        });
    });
</script>

</body>

</html>
