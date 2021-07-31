<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

function avatar(){
    return Arr::first(Session::get('user_images'));
}

function isOnline()
{
    echo ( Auth::check())? '1' : '0';
}

function number_format_short( $n, $precision = 1 ) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
}

function saber_dia($nombredia) {
    $dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');
    $fecha = $dias[date('N', strtotime($nombredia))];
    return  $fecha;
}

function resta_fecha($fecha_actual, $dias){
    return date("Y-m-d",strtotime($fecha_actual."- $dias days"));
}
