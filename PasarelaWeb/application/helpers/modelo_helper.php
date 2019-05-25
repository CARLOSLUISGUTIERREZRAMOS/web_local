<?php

if (!function_exists('get')) {

    function GetDiaNombre($dia_w) {
        switch ($dia_w) {
            case 0: $nombre_dia_semana = "domingo";
                break;
            case 1: $nombre_dia_semana = "lunes";
                break;
            case 2: $nombre_dia_semana = "martes";
                break;
            case 3: $nombre_dia_semana = "miercoles";
                break;
            case 4: $nombre_dia_semana = "jueves";
                break;
            case 5: $nombre_dia_semana = "viernes";
                break;
            case 6: $nombre_dia_semana = "sabado";
                break;
        }
        return $nombre_dia_semana;
    }
    
}
