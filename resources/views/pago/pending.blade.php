@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="display-4 text-center">Pago Fallido</h1>
                    <p class="lead text-center">
                        Ha ocurrido un error en el proceso de pago
                    </p>
                    <hr class="my-4">

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