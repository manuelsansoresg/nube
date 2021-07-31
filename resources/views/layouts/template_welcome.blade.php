<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('keywords')">
    <link href="{{ asset('img/logos/favicon.png') }}" rel="shortcut icon" type="image/png" />

    <title>{{ config('app.name', 'Nnnube') }} @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('add_css')
</head>
<body>
    @yield('content')
    <script src="{{ asset('js/WOW.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('add_js')
</body>
</html>