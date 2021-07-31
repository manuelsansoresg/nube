@extends('layouts.app')

@section('content')
<div class="login">
    <div class="container">
        <div class="row justify-content-center mt-5 mt-md-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="text-center mt-3">
                        <h2 class="text-muted login__title">{{ __('Iniciar sesión') }}</h2>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                {{--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope prefix"></i>
                                            </span>
                                        </div>
                                        <input id="login" type="login" class="form-control" name="login" value="{{ old('login') }}" required autofocus placeholder="Nombre de Usuario">
                                    </div>
                                    @if ($errors->has('login'))
                                    <span class=”help-block”>
                                        <small class="text-danger">{{ $errors->first('login') }}</small>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock prefix"></i>
                                            </span>
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2 text-right ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label " for="remember">
                                            {{ __('Recuérdame') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-10 text-right mt-n2">
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link " href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary col-12">
                                        {{ __('Iniciar sesión') }}
                                    </button>


                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection