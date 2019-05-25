<?php

if (!function_exists('ddi_solonumero')) {
    function ddi_solonumero($ddi) {
        return str_ireplace('+', '', $ddi);
    }
}