@extends('layouts.cliente')

@section('title', 'cliente')

@section('content')

    <!-- component -->
    <div>
        <div class="flex">
            <!-- aside -->
            <aside class="flex w-72 flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2" style="height: 90.5vh"
                x-show="asideOpen">

                <p class="my-5 text-center font-semibold text-sm text-gray-500 font-sans uppercase">Categorias</p>

                @foreach ($categorias as $categoria)
                    <a href="#"
                        class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                        <span class="text-2xl"><i class="bx bx-home"></i></span>
                        <span>{{ $categoria->nombre }}</span>
                    </a>
                @endforeach
            </aside>

            <!-- Los productos -->
            <div class="w-full p-4">
                <div class="px-10 py-10 bg-white grid gap-10 lg:grid-cols-3 xl:grid-cols-3 sm:grid-cols-2">
                    @foreach ($productos as $producto)
                        <div
                            class="max-w-xs  rounded-lg overflow-hidden border-gray-400 hover:border-gray-800 bg-white border-4 cursor-pointer">
                            <div>
                                <iframe height="250" width="320" scrolling="no" src="{{ $producto->imagen }}"
                                    frameBorder="0"></iframe>

                            </div>
                            <div class="py-4 px-4 bg-white">
                                <h3 class="text-md font-semibold text-gray-600">
                                    <strong>Producto:</strong>
                                    {{ $producto->nombre }}
                                </h3>
                                <h3 class="my-2 text-md font-semibold text-gray-600">
                                    <strong>Descripcion:</strong>
                                    {{ $producto->descripcion }}
                                </h3>
                                @foreach ($marcas as $marca)
                                    @if ($marca->id == $producto->marca_id)
                                        <h3 class="my-2 text-md font-semibold text-gray-600">
                                            <strong>Marca:</strong>
                                            {{ $marca->nombre }}
                                        </h3>
                                    @endif
                                @endforeach
                                <h3 class="my-2 text-md font-semibold text-gray-600">
                                    <strong>Disponible:</strong>
                                    {{ $producto->stock }}
                                </h3>

                                <input type="text" class="border-gray-400 border-2 rounded-md text-center hover:bg-gray-200"
                                    name="cantidad" id="cantidad" pattern="[1-9]\d*"
                                    placeholder=" -- Cantidad --" autofocus required>
                                @error('cantidad')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                                <p class="text-right text-2xl font-thin">{{ $producto->precio }} BS</p>

                                <span
                                    class="flex items-center justify-center mt-4 w-full bg-yellow-400 hover:bg-yellow-500 py-1 rounded transform transition duration-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <button class="font-semibold text-gray-800 ">Add to Basket</button>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $productos->links() }}

            </div>
        </div>

    </div>



@endsection


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @livewireStyles
@stop

@section('js')
    <script>
        console.log('hi!')
    </script>
    @livewireScripts
@stop
