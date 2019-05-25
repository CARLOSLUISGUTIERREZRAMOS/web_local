<?php

if (!function_exists('fecha_iso_8601')) {

    function fecha_iso_8601($fecha_human) {
        $date = str_replace('/', '-', $fecha_human);
        $fecha2 = date("Y-m-d", strtotime($date));
        return $fecha2;
    }

}
if (!function_exists('ObtenerHoraVuelo')) {

    function ObtenerHoraVuelo($fecha_iso_8601) {
        return (new DateTime($fecha_iso_8601))->format('H:i:s');
    }

}
if (!function_exists('FormarDuracionVuelo')) {

    function FormarDuracionVuelo($fecha_iso_8601) {
        $Horas = (new DateTime($fecha_iso_8601))->format('H');
        $minutos = (new DateTime($fecha_iso_8601))->format('i');
        return $Horas . ' hrs. ' . $minutos . ' mins.';
//        return strftime("%H -%i", strtotime(fecha_iso_8601($fecha_iso_8601)));
    }

}

if (!function_exists('FechaLetras_ES')) {

    function FechaLetras_ES($Fecha_Ymd, $forma) {
        date_default_timezone_set('Europe/Madrid');
        // En windows
        setlocale(LC_TIME, 'spanish');
        // Unix
//        setlocale(LC_TIME, 'es_ES.UTF-8'); PROD
        switch ($forma) {
            case 'short':
                $fecha_es = strftime("%a, %d %b", strtotime(fecha_iso_8601($Fecha_Ymd)));
                break;
            case 'large':
                $fecha_es = strftime("%A, %d de %B", strtotime(fecha_iso_8601($Fecha_Ymd)));
                break;
        }

        return utf8_encode($fecha_es);
    }

}
if (!function_exists('FechaOperaLetras_ES')) {
    /*
     * @Fecha_Ymd => Parametro tipo string con formato d/m/y, fecha de salida elegida por el pasajeto
     * @Dias => Cantidad de dias a aumentar o restar.
     */

    function FechaOperaLetras_ES($Fecha_Ymd, $Dias) {
        date_default_timezone_set('Europe/Madrid');
        setlocale(LC_TIME, 'spanish');
        $FechaUnixOperado = strtotime("$Dias day", strtotime(fecha_iso_8601($Fecha_Ymd)));
        $fecha_es = strftime("%a, %d %b", $FechaUnixOperado);
        return utf8_encode($fecha_es);
    }

}

if (!function_exists('RestarFecha')) {
    /*
     * @Fecha_Ymd => Parametro tipo string con formato d/m/y, fecha de salida elegida por el pasajeto
     * @Dias => Cantidad de dias a aumentar o restar.
     */

    function RestarSumarFecha($Fecha_Ymd, $Dias) {
//        return fecha_iso_8601($Fecha_Ymd);
        $FechaUnixOperado = strtotime("$Dias day", strtotime(fecha_iso_8601($Fecha_Ymd)));
        return strftime("%d/%m/%Y", $FechaUnixOperado);
    }

}

if (!function_exists('ValidarFechaIda')) {

    function ValidarFechaIda($fechadmY,$date_to) {
        $fecha_entrada = strtotime(fecha_iso_8601($fechadmY));
        $fecha_date_to = strtotime(fecha_iso_8601($date_to));
        $fecha_hoy_sistema = (new DateTime())->format('Y-m-d');
        $fecha_sistema = strtotime($fecha_hoy_sistema);
//        $RES = ($fecha_entrada >= $fecha_sistema) ? '' : 'disabled';
//            return fecha_iso_8601($fechadmY) . '|'.fecha_iso_8601($date_to);
//        return ($fecha_entrada <= $fecha_sistema && $fecha_entrada > $fecha_date_to) ? 'disabled' : 'disabled';
        if($fecha_entrada > $fecha_date_to || $fecha_entrada < $fecha_sistema ){
            return 'disabled enlace_desactivado';
        } else{
            return 'enabled';
        }
    }

}
if (!function_exists('ValidarMuestraSabTarifaria')) {

    function ValidarMuestraSabTarifaria($fechadmY, $fecha_compara) {
        $fecha_entrada = strtotime(fecha_iso_8601($fechadmY));
        $fecha_compa = strtotime(fecha_iso_8601($fecha_compara));
//        return $fechadmY . '|' . $fecha_compara;
        return ($fecha_entrada < $fecha_compa) ? 'disabled enlace_desactivado' : '';
    }

}




