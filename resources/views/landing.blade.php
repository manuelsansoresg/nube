@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        
        @if($user != '')
        <div class="col-12 text-center ">
            <a class="lnk-random" href="/usuario/{{ $user->id }}">
                <img class="rounded-circle img-fluid" id="img-rand" src="{{ asset($path.'/'.$user->id.'/thumb-'.$user->photo) }}">
            </a>
            <p>
                <a class="lnk-random" href="">
                    <span id="user-random" class="badge badge-success">
                        {{ $user->username }}
                    </span>
                </a>
            </p>
            <p class="h6 text-muted"> + vistos </p>
        </div>
        @endif

        

    </div>
    {{-- leyenda --}}
    <div class="col-12 text-center mt-2 pb-5 ">
        <p class="h4 mt-n3 landing__title">
            Regala amor
        </p>
        <p>
            <i class="fas fa-heart heart-small text-danger"></i>
        </p>
        <p class="mt-n3 h4 landing__subtitle">tus corazones se renuevan cada primero de mes</p>
        <div class="row">
            <div class="col-10 offset-1">

            </div>
        </div>
    </div>

    {{-- leyenda --}}

    {{-- my user--}}
    @if($my_user != null)
    <div class="row justify-content-center">
        <div class="col-9 col-md-8 list-user bg-white pb-3">
           {{-- <div class="row mt-3">
                <div class="col-4 col-md-4 offset-0 offset-md-1"><span class="font-weight-bold text-muted list-user__head">Mi usuario</span></div>
                <div class="col-3 col-md-2 offset-0 offset-md-3"><span class="font-weight-bold text-muted list-user__head">Seguidores</span></div>
                <div class="col-1 col-md-1 offset-md-2"> <i class="fas fa-heart heart-small text-danger heart"></i></div>
            </div>--}}
            <div class="row mt-4">
                <div class="col-2 col-md-2 offset-md-1">
                    <a href="/usuario/{{ $my_user->id }}">
                        <img  src="{{ asset($path.'/'.$my_user->id.'/thumb-'.$my_user->photo) }}" alt="Profiler" class="rounded-circle shadow img-fluid">
                    </a>
                 
                </div>
                <div class="col-2 col-md-2 align-self-center"> <span class="small">{{ $my_user->username }}</span> </div>
               {{-- <div class="col-md-3  align-self-center d-none d-md-block"> <span class="small">{{ $my_user->name_state }} - {{ $my_user->name_town }} </span> </div>--}}
                <div class="col-4  col-md-3  align-self-center">
                    <span class="small" id="my_follow"> <span class="">Seguidores</span> <span class="ml-3">{{ number_format_short($my_user->follow_me) }}</span> </span>
                </div>
                <div class="col-3 offset-1 offset-md-0 col-md-2 align-self-center">
                    <span class="small" id="my-heart">{{ number_format_short($my_user->heart) }}</span>
                    <i class="fas fa-heart heart-small text-danger ml-2"></i>
                </div>
            </div>

        </div>
    </div>
    @endif
    {{-- my user--}}
    <div class="col-12 pb-5 mt-3">
            <search-component path="{{ $path }}" status_user="{{ isOnline() }}" heart="{{ (isset($my_user) && $my_user != null) ? $my_user->heart : 0 }}"></search-component>
    </div>  
    {{-- busqueda--}}

    <title-component user_id="null" path="{{ $path }}" is_my_title="1" status_user="{{ isOnline() }}" heart="{{ (isset($my_user) && $my_user != null) ? $my_user->heart : 0 }}"></title-component>
    {{-- busqueda--}}
    @if (Auth::guest())
    <div class="row mt-5 pb-5">
        <div class="col-12 text-center">
            <a href="/login" class="btn btn-sm btn-outline-primary btn-rounded ml-2 btn-consigue shadow px-2 px-md-3">Inicia sesión <br>
                y consigue 30
                <i data-v-89b0c3cc="" class="fas fa-heart heart-small text-danger heart"></i>
            </a>
        </div>
    </div>
    @endif

    {{-- descubre --}}
    {{-- <div class="row mt-5">
        <div class="col-12 text-center">
            <canvas id="tagcanvas" width="500" height="500"></canvas>
            <div id="iconTags" class="d-none">
                @foreach($users as $user)
                <a id="link-{{ $user->position }}" title="{{ $user->username }}" href="/usuario/{{ $user->id }}">
                    <img class="rounded-circle image-tags" id="image-" width="50" height="50" src="{{ asset($path.'/'.$user->id.'/thumb-'.$user->photo) }}" alt="Icon 0" />
                </a>
                @endforeach
            </div>
        </div>





    </div> --}}
    {{-- /descubre --}}

</div>
@endsection
