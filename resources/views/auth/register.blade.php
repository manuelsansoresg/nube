@extends('layouts.app')

@section('content')
<div class="register">
    <div class="container">

        {{ Form::open(['route' => 'usuario_register.store', 'method' => 'POST', 'files' => true, 'id' => 'form-registro']) }}
        <div class="row justify-content-center">

            <div class="col-md-6 card mt-20">
                <div class="text-left mt-2">
                    <span class="small text-muted">Registro gratuito <i class="fas fa-heart heart-small"></i></span>
                </div>
                <div class="text-center mt-3">
                   
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <img class="img-fluid register__preview rounded-circle shadow mt-2" id="image_preview" src="{{ asset('img/logos/nubewhite.png') }}" alt="">
                        <p class="text-muted mt-3">Foto de perfil</p>
                        <input type="file" id="photo" name="photo" class="d-none" />
                        <span class="text-danger" id="result"> </span>

                        <small class="text-danger registro-error photo"></small>
                    </div>
                    <div class="form-group col-12 mt-4">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Usuario">
                        <small class="text-danger registro-error username"></small>
                    </div>
                    <div class="form-group col-12 col-md-12">
                        <ul class="list-inline">
                            @foreach($socials as $social)
                            <li class="list-inline-item">
                                <i class="rd {{ $social->class }} m-1 circle-fa fa-social item" data-name="{{ $social->url }}" data-id="{{ $social->id }}">
                                    <i class="{{ $social->icon }}"></i>
                                </i>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    <div class="input-group col-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span id="sitio-url">http://</span>
                            </span>
                        </div>
                        <?php $cont_social = 0; ?>
                        @foreach($socials as $social)
                        <?php
                        $cont_social = $cont_social + 1;
                        $visible = ($cont_social > 1) ? 'd-none' : '';
                        ?>
                        <input type="text" name="social[]" id="social-{{ $social->id }}" class="form-control {{ $visible }} item-social" placeholder="Tú sitio">
                        <input type="hidden" name="social_id[]" value="{{ $social->id }}">
                        @endforeach

                    </div>

                </div>
                <div class="w-100 pb-3"></div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock prefix"></i>
                                </span>
                            </div>

                            <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">

                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock prefix"></i>
                                </span>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña">
                            <div class="w-100"></div>
                            <small class="text-danger registro-error password"></small>
                        </div>
                    </div>
                    <div class="col-12 mt-n3">
                        <small class="text-danger" id="error-password"></small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user prefix"></i>
                                </span>
                            </div>

                            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre">
                            <div class="w-100"></div>
                            <small class="text-danger registro-error name"></small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user prefix"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="last_name" placeholder="Apellido">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope prefix"></i>
                                </span>
                            </div>

                            <input type="email" name="email" id="email" class="form-control" placeholder="Correo">
                            <div class="w-100"></div>
                            <small class="text-danger registro-error email"></small>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <select name="state_id" id="state_id" class="form-control">
                                <option value="">-Estado-</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>

                            <div class="col-12 ml-n3 ml-md-n4 text-left text-md-center ">
                                <small class="text-danger registro-error state_id"></small>
                            </div>
                        </div>
                    </div> --}}
                </div>

               {{--  <div class="form-row">
                    <div class="col-12 col-md-6 offset-md-3">
                        <select name="town_id" id="town_id" class="form-control">
                            <option value="">-Municipio-</option>
                        </select>
                        <div class="col-12 ml-n3 ml-md-n4 text-left text-md-center ">
                            <small class="text-danger registro-error town_id" id="error-town_id"></small>
                        </div>
                    </div>
                </div> --}}
                <div class="form-row">
                    <div class="col-12 col-md-12 mt-3 text-center">
                        <label for="validationTooltipUsername" class="text-muted">Biografia</label>
                        <textarea class="form-control" name="biography" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="row" id="spinner-registro" style="display: none">
                    <div class="col-12 text-center mt-5">
                        <i class="fas fa-spinner fa-spin text-success"></i>
                    </div>
                </div>
                <div class="form-row pb-3">
                    <div class="col-12 col-md-12 mt-3 text-center">
                        <button class="btn btn-success col-6 ">Registrar</button>
                    </div>
                </div>

                </div>

        </div>
            {{ Form::close() }}

    </div>
</div>
        @endsection