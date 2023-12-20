@extends('layouts.app')

@section('content')
    <!-- Create By Joker Banny -->
    <?php
    $configuracion = DB::table('configurations')->where('id', 1)->first();
    $modo = isset($_COOKIE['modo']) ? $_COOKIE['modo'] : 'dia'; // Verificar la preferencia almacenada en las cookies
    ?>
   
    <div class="min-h-screen bg-no-repeat bg-cover bg-center"
        style="background-image: url('{{ $modo === 'dia' ? 'https://a-static.besthdwallpaper.com/apartamento-tienda-papel-pintado-1440x960-23850_37.jpg' : 'URL_DE_TU_IMAGEN_NOCTURNA' }}');
        filter: brightness({{ $modo === 'dia' ? '100%' : '70%' }});">
        <div class="flex justify-end">
            <div class="bg-yellow-400 min-h-screen w-1/2 flex justify-center items-center">
                <div>
                <button id="cambiarModo" class=" hover:text-gray-300">Cambiar Modo</button>
                <button id="aumentarLetra" class="hover:text-gray-300">Aumentar Letra</button>
                <button id="disminuirLetra" class="hover:text-gray-300">Disminuir Letra</button>
     <form class="p-20 bg-white rounded-3xl flex justify-center items-center flex-col shadow-md" method="POST"
                        action="{{ route('login') }}">
                        @csrf
                        <div>
                            <span class="text-sm text-gray-900">Bienvenido a {{$configuracion->razon_social}} Online</span>
                            <h1 class="text-2xl font-bold">Inicia Session</h1>
                        </div>
                        <div class="my-3">
                            <label class="block text-md mb-2" for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror px-6 w-full border-2 py-2 rounded-md text-sm outline-none"
                                name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email"
                                autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-5">
                            <label class="block text-md mb-2" for="password">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror px-6 w-full border-2 py-2 rounded-md text-sm outline-none"
                                name="password" required autocomplete="current-password" placeholder="password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="flex justify-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit"
                                class="mt-4 mb-3 w-full bg-blue-500 hover:bg-blue-400 text-white py-2 rounded-md transition duration-100">
                                {{ __('Login') }}
                            </button>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-700 hover:underline cursor-pointer"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                        <br>
                        <p> Si no tienes cuenta registrate:</p>
                        <div>
                            <br>
                            <a href="{{ route('register') }}"
                                class="font-semibold border-2 border-blue-800 py-2 px-4 rounded-md hover:bg-blue-800 hover:text-white">Crear Cuenta</a>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const botonCambiarModo = document.getElementById('cambiarModo');
                    let modoActual = localStorage.getItem('modo') || 'dia';
                    aplicarModo(modoActual);

                    botonCambiarModo.addEventListener('click', function() {
                        modoActual = modoActual === 'dia' ? 'noche' : 'dia';
                        localStorage.setItem('modo', modoActual);
                        aplicarModo(modoActual);
                    });

                    function aplicarModo(modo) {
                        const contenedorPrincipal = document.getElementById('contenedorPrincipal');
                        contenedorPrincipal.classList.toggle('modo-dia', modo === 'dia');
                        contenedorPrincipal.classList.toggle('modo-noche', modo === 'noche');

                        const intensidad = modo === 'dia' ? '100%' : '70%';
                        document.body.style.filter = `brightness(${intensidad})`;
                    }
                });
            </script>
    <script>
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
@endsection
