@extends('layouts.cliente')

@section('title', 'Perfil')

@section('content')
    @if (session('info'))
        <div class="alert mt-2">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ session('info') }}
        </div>
    @endif

    @if (session('info2'))
    <div class="alert2 mt-2">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        {{ session('info2') }}
    </div>
@endif

    <div class=" bg-white  dark:bg-white  flex  items-center  justify-center  ">
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
            <div class="">
                <div class="text-center px-14">
                    {!! Form::model($cliente, ['route' => ['cliente.updatePassword'], 'method' => 'POST', 'autocomplete' => 'off']) !!}
                    <h2 class="text-gray-800 text-3xl font-bold">{{ $cliente->name }}</h2>
                    <br>

                    <p class="font-bold mt-3 text-1xl">Nueva Contraseña</p>
                    <input type="password" style="width : 350px;"
                        class="border-black border-2 rounded-md text-center hover:bg-gray-200" name="NewPassword" autofocus required>
                    <br>
                    @error('NewPassword')
                        <strong class="text-red-500">{{ $message }}</strong>
                    @enderror
                    <p class="font-bold mt-3 text-1xl">Repita la Nueva Contraseña</p>
                    <input type="password" style="width : 350px;"
                        class="border-black border-2 rounded-md text-center hover:bg-gray-200" name="New2Password"
                        autofocus required >
                    <br>
                    @error('New2Password')
                        <strong class="text-red-500">{{ $message }}</strong>
                    @enderror
                    <br>
                    <div class="text-center px-20">


                        <span
                            class="flex items-center mt-3 mb-3 justify-center w-full bg-yellow-400 hover:bg-yellow-500 hover:text-white py-1 rounded transform transition duration-100 hover:scale-105">
                            <button type="submit" rel="tooltip">
                                <i class="material-icons fa fa-pen">
                                    Cambiar Contraseña
                                </i>
                            </button>
                        </span>


                    </div>

                    <br>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* The alert message box */
        .alert {
            padding: 20px;
            background-color: #09B14C;
            /* Red */
            color: white;
            margin-bottom: 15px;
        }

        .alert2 {
            padding: 20px;
            background-color: #FF0022;
            /* Red */
            color: white;
            margin-bottom: 15px;
        }

        /* The close button */
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* When moving the mouse over the close button */
        .closebtn:hover {
            color: black;
        }
    </style>
    @livewireStyles
@stop

@section('js')
    <script>
        console.log('hi!')
    </script>
    @livewireScripts
@stop
