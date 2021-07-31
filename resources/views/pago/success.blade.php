@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="display-4 text-center">Pago Exitoso</h1>
                    <p class="lead text-center">¡Gracias por comprar el titulo <b><?php //echo $data['titulo'] ?></b> en nnuube!</p>
                    <hr class="my-4">
                    <p>Palabras Clave registradas : <b>
                       {{ $title->title }}
                    </p>
                    <br>
                    <p>
                        Tú titulo sera posicionado organicamente en buscadores
                    </p>
                    <br>
                    <div class="text-center">
                        <a class="btn btn-primary" href="/" role="button">Regresar al sitio</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection