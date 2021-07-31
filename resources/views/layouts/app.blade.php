<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('keywords')">

    <title>{{ config('app.name', 'Nnnube') }} @yield('title')</title>
    {{-- favicon    --}}
    <link href="{{ asset('img/logos/favicon.png') }}" rel="shortcut icon" type="image/png" />


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('add_css')
</head>

<body>
    <nav class="navbar navbar-expand-md ">
        <div class="container">
            <a class="lbl-menu" href="{{ url('/') }}">
                {{--<img src="{{ asset('img/logos/iCgram_black.png') }}" alt="">--}}
                Descubre
            </a>


            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                @if (Auth::guest())
                <a class="btn btn-outline-gray btn-sm btn-sm-menu" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                <a class="btn btn-outline-gray btn-sm btn-sm-menu" href="{{ route('register') }}">{{ __('Regístrate') }}</a>
                @else
                {{ Str::limit(Auth::user()->name,9) }}
                <img class="rounded-circle avatar mx-3" name="imagen" src="{{ asset(avatar()['image_thumb']) }}" alt="">
                <i class="fas fa-angle-down ml-n3"></i>
                @endif
            </button>


            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item d-none d-md-block">
                        <a class="btn btn-outline-gray btn-sm" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item ml-4 d-none d-md-block">
                        <a class="btn btn-outline-gray btn-sm" href="{{ route('register') }}">{{ __('Regístrate') }}</a>
                    </li>
                    @endif
                    @else

                    <li class="nav-item  text-center d-block d-md-none">
                        <a class="dropdown-item" href="/usuario/{{ Auth::user()->id }}"> {{ __('Perfíl') }}</a>
                        <a class="dropdown-item" href="/usuario/{{ Auth::user()->id }}/edit"> {{ __('Editar perfíl') }}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Salir') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                    <li class="nav-item dropdown d-none d-md-block">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-black-50" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                            {{ Auth::user()->name }}
                            <img class="rounded-circle avatar mx-3" name="imagen" src="{{ asset(avatar()['image_thumb']) }}" alt="">
                        </a>


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/usuario/{{ Auth::user()->id }}"> {{ __('Perfíl') }}</a>
                            <a class="dropdown-item" href="/usuario/{{ Auth::user()->id }}/edit"> {{ __('Editar perfíl') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Salir') }}
                            </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>


                    </li>


                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row mt-2 mt-md-3">
            <div class="col-12">
                {{--@include('icon')--}}
            </div>
        </div>
    </div>
    <main class="py-0 py-md-4">

        <div id="app">
            @yield('content')
        </div>
    </main>

    {{-- modal corazones --}}

    {{-- /modal corazones --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/WOW.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('add_js')
</body>

</html>
