@extends('layouts.template_welcome')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-6 text-center">
            <ul class="list-inline landing__list">
                <li class="list-inline-item">Calendario</li>
                <li class="list-inline-item">Palabras Clave</li>
                <li class="list-inline-item">Amigos</li>
            </ul>
            <hr class="hr-home">

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-4 text-center  ">

            <a href="/login" class="">
                <img class="img-fluid" src="{{ asset('img/nube.png') }}" alt="">
            </a>


        </div>

    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-2 text-center">

            <a href="/register">
                <p class="mt-2 text-muted">Registrate es gratis</p>
            </a>
            <p class="mt-5 h1 text-muted">
                nnuube
            </p>
            <p class="mt-5 text-small text-muted pb-0 mb-0"> Proximamente </p>

        </div>

    </div>

    <div class="row justify-content-center">
        <div class="col-4 col-md-2">
            <div>
                <img class="img-fluid" src="{{ asset('img/iconosapp.png') }}" alt="">
            </div>
        </div>
    </div>

</div>
@endsection