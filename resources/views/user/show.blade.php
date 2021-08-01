@extends('layouts.app')

@section('keywords', $keywords )

@section('add_css')
<link rel="stylesheet" href="/public_vendor/jquery_tags/jquery.tagsinput.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
            @if (isset($my_user->id))
                <img class="img-fluid rounded-circle shadow" src="{{ asset($path.'/'.$my_user->id.'/'.$my_user->photo) }}" alt="">
            @endif

            <input type="hidden" id="userId" value="{{ $userId }}">
            <input type="hidden" id="WEBROOT" value="{{ asset('/') }}" />
            <input type="hidden" id="day" value="<?= date('d'); ?>" />
            <input type="hidden" id="month" value="<?= date('m'); ?>" />
            <input type="hidden" id="year" value="<?= date('Y'); ?>" />
            <input type="hidden" id="date" value="<?= date('Y-m-d'); ?>" />
            <input type="hidden" id="my_user" value="{{ ($my_user_id != null)? $my_user_id : 0 }}">
            

        </div>
        <div class="col-12 col-md-9 mt-3">
            <div class="row">
                <div class="col-12 col-md-8 d-flex justify-content-between">
                    <div><span class="h3">{{ (isset($my_user->username))?$my_user->username : '' }}</span></div>
                    <div>
                        <btn-follow is_follow="{{ $btn_follow }}" user_id="{{ $userId }}"></btn-follow>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 col-md-3">
                    {{-- <followed-component followed="{{ (isset($my_user->follows))? $my_user->follows : ''}}" path="{{ '/'.$path }}" my_user_id="{{ $userId }}"></followed-component> --}}
                    @livewire('followed-component', ['followed' => (isset($my_user->follows))? $my_user->follows : '', 'path' =>  '/'.$path  , 'my_user_id' =>  $userId  ])
                    {{--<span class="text-muted font-weight-bold">   <span class="text-muted font-weight-normal">Seguidos</span> </span>--}}
                </div>
                <div class="col-5 col-md-4"><span class="text-muted font-weight-bold">
                    @livewire('followers-component', ['followers' => isset($my_user->follow_me)? $my_user->follow_me : '', 'path' => '/'.$path, 'my_user_id' =>  $userId  ])
                        {{-- <followers-component followers="{{ isset($my_user->follow_me)? $my_user->follow_me : ''  }}" path="{{ '/'.$path }}" my_user_id="{{ $userId }}"></followers-component> --}}
                </div>
                <div class="col-3 col-md-3">
                    <a class="pointer" data-toggle="modal" data-target="#hearts">
                        <span class="text-muted font-weight-bold"> <span id="my-heart">{{ (isset($my_user->heart))?number_format_short($my_user->heart): '' }}</span>
                            <i class="fas fa-heart heart-small text-danger heart"></i>
                        </span>
                    </a>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 col-md-3"> <span class="text-muted">{{ (isset($my_user->name))?$my_user->name.' '.$my_user->last_name: '' }}</span> </div>
                <div class="col-8 col-md-4"><span class="text-muted">{{ (isset($my_user->name_town))?$my_user->name_town.' '.$my_user->name_state: '' }} </span></div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-8 text-center">
                    <span class="text-muted">{{ isset($my_user->biography)?$my_user->biography : '' }}</span>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-md-8 text-center">
                    <div class="form-group text-center">
                        <ul class="list-inline">
                            @foreach($my_socials as $my_social)
                            <li class="list-inline-item">
                                <a href="{!! $my_social->link !!}{!! $my_social->url !!}" target="_blank">
                                    <i class="{{ $my_social->icon }} text-secondary icons-social"></i>
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

{{--calendario--}}
<div class="container">
    <div class="row">
        <div class="col-12">
            <article class="text-center pt-3" id="calendar">
                <div class="calendarHeader">
                    <div class="btnMonth">
                        <button type="button" class="btn  btn-outline-primary btn-rounded waves-effect btn-sm" id="btnLastMonth">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </div>
                    <div class="nameMonth p-2">
                        <h5>
                            <p id="monthLast" class="h5 d-none"></p>
                        </h5>
                        <h3>
                            <p class="currentMonth h3  d-inline">Noviembre</p>
                        </h3>
                    </div>
                </div>
                <div class="calendarBody">
                    <div class="daysWeek row">
                        <div class="calendarDay itenCalendar">Lun</div>
                        <div class="calendarDay itenCalendar">Mar</div>
                        <div class="calendarDay itenCalendar">Mie</div>
                        <div class="calendarDay itenCalendar">Jue</div>
                        <div class="calendarDay itenCalendar">Vie</div>
                        <div class="calendarDay itenCalendar">Sab</div>
                        <div class="calendarDay itenCalendar">Dom</div>
                    </div>
                    <div class="daysWeek row" id="dayForMonth"></div>
                </div>
                <div class="calendarFooter">
                    <div class="nameMonth p-2">
                        <h6>
                            <span class="currentMonth h5 d-none">Noviembre</span>

                            <span class="currentYear h5 h5 d-none">2018</span>
                        </h6>
                        <h3>
                            <p id="monthNext" class="h3"></p>
                        </h3>
                    </div>
                    <div class="btnMonth">
                        <button type="button" class="btn btn-outline-primary btn-rounded waves-effect btn-sm" id="btnNextMonth">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
{{--/calendario--}}

{{-- titulo --}}
@if ($userId == $my_user_id )
<div class="container">
    <div class="row mt-4 justify-content-center">
        <div class="col-7 col-md-7 text-center">
            <button class="btn  shadow col-12 col-md-7 btn-primary" data-toggle="modal" data-target="#newTittle">PALABRAS CLAVE</button>
            <small class="d-block mt-2">Busca las palabras clave en buscadores</small>
        </div>
    </div>
</div>
@endif
{{-- /titulo --}}

<div class="pb-5">
    <title-component user_id="{{ $userId }}" is_my_title="0" status_user="{{ isOnline() }}" heart="{{ (isset($my_user) && $my_user != null) ? $my_user->heart : 0 }}"></title-component>
</div>

{{-- modal regala corazones --}}
<div class="modal fade" id="hearts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!-- Change class .modal-sm to change the size of the modal -->
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height: auto !important;">
            <div class="modal-header">
                <h4 class="modal-title font-weight-light text-center" id="myModalLabel">
                    Regala amor
                    <i class="fas fa-heart  text-danger"></i>
                    <span>tus corazones se renuevan cada mes</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p class="text-center">
                    Total de <i class="fas fa-heart heart-small text-danger"></i>
                    {{ isset($my_user->heart)? $my_user->heart : '' }}
                </p>
            </div>
        </div>
    </div>
</div>
{{-- /modal regala corazones --}}

{{-- modal titulo --}}
<div class="modal fade" id="newTittle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-title">
                @include('icon')

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-white">

                <div class="text-center">
                    <span>
                        <span class="text-muted font-weight-bold"> PALABRAS CLAVE </span>

                    </span>

                    <p>

                        <span class="text-muted font-weight-bold"> 100 mxn 2 años
                        </span>
                    </p>
                    <p class="mt-5">

                        <span class="text-muted font-weight-bold">Recibe<i class="fas fa-heart heart-medium text-danger ml-2"></i>
                            </i> y posicionate en nnuube</b> </span> <br>
                    </p>
                    <p class="small font-weight-bold mt-4">
                        Estas pagando por el espacio generado en nnube
                    </p>
                    <p class="small font-weight-bold mt-4 mb-0">

                        * extra sin costo
                    </p>
                    <div class="small text-center font-weight-bold">
                        nnuube enlaza de forma gratuita tus Palabras Clave con Buscadores
                    </div>

                    <p class="small mt-4 font-weight-bold mb-0">
                        Pesonas, Marcas, Establecimientos, Productos, Servicios
                    </p>
                    <div class="small text-center font-weight-bold">
                        TODO LO QUE SE TE OCURRA.
                    </div>
                </div>


                <br>
                <form action="" id="form-title">
                    @csrf
                    <div class="form-group d-none">
                        <input type="text" name="title" placeholder="escribe tus palabras clave" maxlength="64" id="titulo" class="form-control form-control-title" />
    
                        <small class="text-muted">
                            Limite de caracteres <span id="number_max">64</span>
                        </small>
                    </div>
    
                    <div class="form-group">
                        <label class="text-muted">Agregar una imagen</label>
                        <input type="file" onchange="valImage(this);" name="imagen" class="form-control" required>     
                        <small class="form-text text-muted">Esta imagen saldra al compartir en tus redes sociales</small>               
                    </div>
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Título">
                        <small class="form-text text-muted">Ejemplo: Veterinaria  petsop en Playa del carmen</small>
                    </div>
                    
                    <div class="form-group">
                        <textarea name="descripcion" placeholder="Palabras clave separadas por ," cols="30" rows="5" class="form-control"></textarea>
                        <small class="form-text text-muted">Ejemplo: Somos la mejor veterinaria en playa del carmen ofrecemos atencion 24 hrs y contamos con una tienda surtida para tus mascotas </small>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="palabras_clave" class="form-control" placeholder="Palabras clave separadas por ,">
                        <small class="form-text text-muted">Ejemplo: Veterinaria, tienda de mascotas, petsop, tienda en playa del carmen</small>
                    </div>
    
                    {{-- <input type="text" name="title" id="title" class="form-control" /> --}}
                    <small class="text-danger title-error title"></small>
                    {{--<small class="text-danger titulos-error tags"></small>--}}
    
                    <div class="form-group">
                        <i class="fas fa-spinner fa-spin  spinner" style="display: none"></i>
                    </div>
                    <div class="form-group text-center">
                        <small>
                            <b>* Estas pagando por el espacio creado en nnuube</b>
                        </small>
                    </div>
                    
                    <div class="form-group col-12 text-center" id="spinner-titulos" style="display: none">
                        <i class="fas fa-spinner fa-spin text-success"></i>
                    </div>
                    
                    <div class="form-group text-center">
                        <input type="hidden" id="token_pay" name="token" value="{{ csrf_token() }}">
                        <input type="hidden" id="btn-mercado" name="btn-mercado" value="{{ create_button() }}">
                        
                        <button type="submit" class="btn btn-primary mt-3 btn-sm">
                            Comprar <i class="fas fa-heart heart-small text-danger ml-2"></i>
                        </button>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $userId }}">
                </form>
            </div>
        </div>
    </div>
</div>

{{-- /modal titulo --}}

{{-- modal alta foto--}}
<div class="modal fade" id="loadPhoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold" id="fechaParaSurbirFoto"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                {{--<form action="#" class="none" enctype="multipart/form-data" id="formNewPhoto">--}}
                {{ Form::open([ 'method' => 'POST', 'files' => true, 'id' => 'formNewPhoto']) }}
                <input type="hidden" id="newPhotoCalendarDate" name="date" />
                <input type="file" class="d-none" id="newPhoto" accept="image/jpeg, image/jpg, image/png" name="photo" />

                {{--<input type="hidden" name="user" id="userPhoto" />--}}

                <div class="file-field text-center">
                    <div class="mb-1">
                        <label for="newPhoto" id="contentPhotoCalendar">
                            <img src="{{ asset('img/logos/nubewhite.png') }}" class="z-depth-1-half avatar-pic rounded-circle" alt="Foto de perfil" />
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <small class="text-danger calendar-error photo"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 text-center" id="spinner-calendar" style="display: none">
                        <i class="fas fa-spinner fa-spin text-success"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary" id="insertPhotoCalendar">Subir</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
{{-- /modal alta foto--}}

{{-- modal rewards--}}
<div class="modal fade" id="loadrewards" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3 text-center">
                <h4> has ganado <span id="heart_reward"> 1k </span> <i class="fas fa-heart heart-small text-danger "></i> </h4>
                <small class="font-weight-bold">Válido solo para mes en curso</small>
            </div>
        </div>
    </div>
</div>
{{-- modal rewards--}}

{{--foto actual--}}
<div class="modal fade" id="fullScreenPhoto" tabindex="-1" role="dialog" aria-labelledby="PhotoToDayOfCalendar" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-full">
            <div class="modal-body" id="newRandomPhoto">
                <img id="photo-full" src="" alt="" class="fullScreenPhoto" />
            </div>
            <div class="modal-footer">
                <button type="button" class="close ml-3" data-id="" id="btnCalendarDelete">
                    <i class="fas fa-trash"></i>
                </button>
                <button type="button" class="close ml-3" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{--foto actual--}}

{{--modal calendario--}}
<!-- Central Modal Small -->
<div class="modal fade" id="modalCalendarDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!-- Change class .modal-sm to change the size of the modal -->
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Eliminar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que deseas eliminar esta imagen?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="close ml-3" id="btnDelete">
                    <i class="fas fa-check"></i>
                </button>
                <button type="button" class="close ml-3" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<form action="#" method="#" class="d-none" id="formCalendarDelete">
    <input type="hidden" name="user" value="<?= (isset($userId)) ? $userId : 0 ?>" />
    <input type="hidden" name="fecha" value="" />
</form>
<!-- Central Modal Small -->
{{--modal calendario--}}

@endsection



@section('add_js')
@if (isset($_GET['recompensa']) &&  $_GET['recompensa'] == true)
<script>
    openRewards();
</script>
@endif
@endsection