@extends('layouts.cliente')

@section('title', 'Perfil')

@section('content')

    <div class=" bg-gray-200  dark:bg-gray-800   flex flex-wrap items-center  justify-center  ">
        <div
            class="container lg:w-2/6 xl:w-2/7 sm:w-full md:w-2/3    bg-white  shadow-lg    transform   duration-200 easy-in-out">
            <div class=" h-32 overflow-hidden">
                <img class="w-full"
                    src="https://png.pngtree.com/thumb_back/fw800/back_our/20190622/ourmid/pngtree-network-information-electronic-technology-background-image_209089.jpg"
                    alt="" />
            </div>
            <div class="flex justify-center px-5  -mt-12">
                <img class="h-32 w-32 bg-white p-2 rounded-full   "
                    src="https://archive.org/download/HeaderIconUser/Header-Icon-User.png" alt="" />

            </div>
            <div class=" ">
                <div class="text-center">
                    {!! Form::model($cliente, ['route' => ['cliente.datos.update', $cliente->id], 'method' => 'put', 'autocomplete' => 'off']) !!}
                    <p class="font-bold text-2xl">Nombre</p>
                    <input type="text" style="width : 350px;"
                        class="border-black border-2 rounded-md text-center hover:bg-gray-200" name="name"
                        placeholder="{{ $cliente->name }}" value="{{ $cliente->name }}" autofocus>
                    <br>
                    @error('name')
                        <strong class="text-red-500">{{ $message }}</strong>
                    @enderror
                    <p class="mt-3 font-bold text-2xl">Email</p>
                    <input type="text" style="width : 350px;"
                        class="border-black border-2 rounded-md text-center hover:bg-gray-200" name="email"
                        placeholder="{{ $cliente->email }}" value="{{ $cliente->email }}" autofocus>
                    <br>
                    @error('email')
                        <strong class="text-red-500">{{ $message }}</strong>
                    @enderror

                    <p class="mt-3 font-bold text-2xl">Carnet</p>
                    <input type="text" style="width : 350px;"
                        class="border-black border-2 rounded-md text-center hover:bg-gray-200" name="ci"
                        placeholder="{{ $cliente->ci }}" value="{{ $cliente->ci }}" autofocus>
                    <br>
                    @error('ci')
                        <strong class="text-red-500">{{ $message }}</strong>
                    @enderror

                    <p class=" mt-3 font-bold text-2xl">Direccion</p>
                    <input type="text" style="width : 350px;"
                        class="border-black border-2 rounded-md text-center hover:bg-gray-200" name="direccion"
                        placeholder="{{ $cliente->direccion }}" value="{{ $cliente->direccion }}" autofocus>
                    <br>
                    @error('direccion')
                        <strong class="text-red-500">{{ $message }}</strong>
                    @enderror

                    <p class=" mt-3 font-bold text-2xl">Telefono</p>
                    <input type="text" style="width : 350px;"
                        class="border-black border-2 rounded-md text-center hover:bg-gray-200" name="telefono"
                        placeholder="{{ $cliente->telefono }}" value="{{ $cliente->telefono }}" autofocus>
                    <br>
                    @error('telefono')
                        <strong class="text-red-500">{{ $message }}</strong>
                    @enderror
                    <br>
                    <br>
                    <div class="text-center px-20">


                        <span
                            class="flex items-center mb-3 justify-center w-full bg-yellow-400 hover:bg-yellow-500 hover:text-white py-1 rounded transform transition duration-100 hover:scale-105">
                            <button type="submit" rel="tooltip">
                                <i class="material-icons fa fa-pen">
                                    editar
                                </i>
                            </button>
                        </span>


                    </div>
                    {!! Form::close() !!}
                    <br>
                </div>
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
