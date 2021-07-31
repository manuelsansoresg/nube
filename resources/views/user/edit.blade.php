@extends('layouts.app')

@section('title', 'Editar perfíl')
    

@section('content')
<div class="register" id="edit-registro">
    <div class="container">
        {{-- editar perfil--}}
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Editar perfil</a>
                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Cambiar contraseña</a>
                </div>
            </div>
            <div class="col-12 col-md-8 mt-3 mt-md-0">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        {{-- editar perfil--}}
                        {{ Form::open(['route' => ['usuario.update', $user->id], 'method' => 'PUT', 'files' => true, 'id' => 'form-registro']) }}
                        <div class="card ml-n0 ml-md-n3">
                            <div class="row justify-content-center">
                                <div class="text-center mt-3 col-12">
                                    {{--<h2 class="text-muted">{{ __('Registrate') }}</h2>--}}
                                </div>
                                <div class="col-12 text-center">
                                    <img class="img-fluid register__preview rounded-circle shadow mt-2" id="image_preview"
                                         src="{{ asset($path.$user->photo) }}" alt="">
                                    <p class="text-muted mt-3 d-block">Foto de perfil</p>
                                    <input type="file" id="photo" name="photo" class="d-none" />
                                    <span class="text-danger" id="result"> </span>
                                    <small class="text-danger registro-error photo"></small>
                                </div>
                                <div class="form-group col-11 col-md-8 mt-4">
                                    <input type="text" name="username" id="username" value="{{ $user->username }}" class="form-control" placeholder="Usuario">
                                    <small class="text-danger registro-error username" ></small>
                                    <input type="hidden" id="user_id" value="{{ $user->id }}">
                                </div>

                                <div class="form-group col-11 col-md-8 text-center">
                                    <ul class="list-inline">
                                        @foreach($socials as $social)
                                            <li class="list-inline-item">
                                                <i class="rd {{ $social->class }} m-1 circle-fa fa-social item"
                                                   data-name="{{ $social->url }}" data-id="{{ $social->id }}">
                                                    <i class="{{ $social->icon }}"></i>
                                                </i>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <div class="input-group col-11 col-md-8 text-center">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <span id="sitio-url">http://</span>
                                            </span>
                                    </div>
                                <?php $cont_social = 0; ?>
                                @foreach($socials as $social)
                                    <?php
                                    $cont_social = $cont_social +1;
                                    $visible = ($cont_social > 1)? 'd-none': '';

                                    ?>
                                        <input type="text" name="social[]" id="social-{{ $social->id }}"
                                               class="form-control {{ $visible }} item-social" placeholder="Tú sitio">

                                    <input type="hidden" name="social_id[]" value="{{ $social->id }}">

                                @endforeach
                                </div>
                                <div class="w-100 pb-3"></div>
                                <div class="form-group col-11 col-md-4 text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-user prefix"></i>
                                            </span>
                                        </div>

                                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" placeholder="Nombre">
                                        <small class="text-danger registro-error name"></small>
                                    </div>
                                </div>

                                <div class="form-group col-11 col-md-4 text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-user prefix"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $user->last_name }}" name="last_name" placeholder="Apellido">
                                    </div>
                                </div>

                                <div class="w-100"></div>
                                <div class="form-group col-11 col-md-8 text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope prefix"></i>
                                        </span>
                                        </div>

                                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" placeholder="Correo">
                                        <small class="text-danger registro-error email"></small>
                                    </div>
                                </div>

                              {{--   <div class="form-group col-11 col-md-4 text-center">
                                    <div class="input-group">
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">-Estado-</option>
                                            @foreach($states as $state)
                                                @if($state->id == $user->state_id)
                                                    <option value="{{ $state->id }}" selected>{{ $state->name }}</option>
                                                @else
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="col-12 ml-n4">
                                            <small class="text-danger registro-error state_id"></small>
                                        </div>
                                    </div>
                                </div> --}}

                              {{--   <div class="form-group col-11 col-md-8 text-center">
                                    <div class="form-row">
                                        <div class="col-12 col-md-6 offset-md-3">
                                            <input type="hidden" id="my_town" value="{{ $user->town_id }}">
                                            <select name="town_id" id="town_id" class="form-control">
                                                <option value="">-Municipio-</option>
                                            </select>
                                            <small class="text-danger registro-error town_id"></small>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-group col-11 col-md-8 text-center">
                                    <div class="form-row">
                                        <div class="col-12 col-md-12 mt-3">
                                            <label for="validationTooltipUsername" class="text-muted">Biografia</label>
                                            <textarea class="form-control" name="biography" cols="30" rows="5">{{ $user->biography }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-12 text-center" id="spinner-registro" style="display: none">
                                    <i class="fas fa-spinner fa-spin text-success"></i>
                                </div>

                                <div class="form-group col-11 col-md-8 text-center">
                                    <button class="btn btn-success col-6 ">Confirmar</button>
                                </div>

                            </div>



                        </div>
                        {{ Form::close() }}
                        {{-- editar perfil--}}
                    </div>
                   {{-- editar password --}}
                   <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                        {{ Form::open(['route' => ['edit_password.update'], 'method' => 'POST', 'id' => 'form-edit-pass']) }}
                        <div class="card ml-n0 ml-md-n3">
                            <div class="row justify-content-center">
                                <div class="text-center mt-3 col-12">
                                    <h2 class="text-muted">{{ __('Cambiar contraseña') }}</h2>
                                </div>
                                <div class="form-group col-8 mt-4">
                                   <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock prefix"></i>
                                            </span>
                                        </div>
                                    
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                                
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="form-group col-8">
                                    <div class="input-group">
                                        <div class="col-12">
                                            <small class="text-danger form-error password"></small>
                                        </div>
                                
                                    </div>
                                </div>

                                <div class="w-100"></div>
                                <div class="form-group col-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock prefix"></i>
                                            </span>
                                        </div>
                                    
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña">
                                    
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                
                                <div class="form-group col-8 mt-1">
                                    <div class="input-group">
                                        <div class="col-12 text-center mt-5" id="spinner-form" style="display: none">
                                            <i class="fas fa-spinner fa-spin text-success" ></i>
                                        </div>
                                
                                    </div>
                                </div>

                                <div class="col-12 mt-1 text-center pb-4">
                                    <button class="btn btn-success col-4 ">Confirmar</button>
                                </div>
                                
                            </div>
                        </div>
                        {{ Form::close() }} 
                    </div>
                   {{-- /editar password --}}
                </div>
            </div>
        </div>
        {{-- /editar perfil--}}


    </div>
    @endsection