<?php

if (!function_exists('ValidarCantidadMaxPax')) {
    function ValidarCantidadMaxPax($adt, $chd, $inf) {
         return ($adt + $chd + $inf > 9) ? FALSE : TRUE;
    }
}