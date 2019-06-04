<?php

if (!function_exists('fecha_iso_8601')) {

    function fecha_iso_8601($fecha_human)
    {
        $date = str_replace('/', '-', $fecha_human);
        $fecha2 = date("Y-m-d", strtotime($date));
        return $fecha2;
    }
}


if (!function_exists('RetornaHorasDiferencias')) {
    function diferencia_hora_vuelo_kiu($fecha_hora_salida, $fecha_hora_sistema)
    {
        $fechaIni = $fecha_hora_salida;
        $fechaFin = $fecha_hora_sistema;
        list($iniDia, $iniHora) = explode(" ", $fechaIni);
        list($anyo, $mes, $dia) = explode("-", $iniDia);
        list($hora, $min, $seg) = explode(":", $iniHora);
        $tiempoIni = mktime($hora + 0, $min + 0, $seg + 0, $mes + 0, $dia + 0, $anyo);
        list($finDia, $finHora) = explode(" ", $fechaFin);
        list($anyo, $mes, $dia) = explode("-", $finDia);
        list($hora, $min, $seg) = explode(":", $finHora);
        $tiempoFin = mktime($hora + 0, $min + 0, $seg + 0, $mes + 0, $dia + 0, $anyo);
        $diferencia = $tiempoIni - $tiempoFin;
        $minutos = ($diferencia / 60);
        return $minutos;
    }
}



if (!function_exists('calcular_estadia')) {

    function calcular_estadia($fecha_hora_salida, $fecha_hora_retorno)
    {
        if (trim($fecha_hora_retorno) == "") {
            return FALSE;
        } else {
            $dias = (strtotime($fecha_hora_retorno) - strtotime($fecha_hora_salida)) / 86400;
            $dias = abs($dias);
            return $dias;
        }
    }
}

if (!function_exists('ValidarFechaRetorno')) {

    function ValidarFechaRetorno($date_from, $date_to)
    {
        $date_to =  strtotime(date($date_to));
        $date_from = strtotime(date($date_from));
        return ($date_to < $date_from) ? FALSE : TRUE;
    }
}

if (!function_exists('ObtenerHoraVuelo')) {

    function ObtenerHoraVuelo($fecha_iso_8601)
    {
        return (new DateTime($fecha_iso_8601))->format('H:i:s');
    }
}
if (!function_exists('ObtenerHoraMinuto')) {

    function ObtenerHoraMinuto($fecha_iso_8601)
    {
        return (new DateTime($fecha_iso_8601))->format('H:i');
    }
}
if (!function_exists('FormarDuracionVuelo')) {

    function FormarDuracionVuelo($fecha_iso_8601)
    {
        $Horas = (new DateTime($fecha_iso_8601))->format('H');
        $minutos = (new DateTime($fecha_iso_8601))->format('i');
        return $Horas . ' hrs. ' . $minutos . ' mins.';
        //        return strftime("%H -%i", strtotime(fecha_iso_8601($fecha_iso_8601)));
    }
}

if (!function_exists('FechaLetras_ES')) {

    function FechaLetras_ES($Fecha_Ymd, $forma)
    {
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

    function FechaOperaLetras_ES($Fecha_Ymd, $Dias)
    {
        date_default_timezone_set('Europe/Madrid');
        setlocale(LC_TIME, 'spanish');
        $FechaUnixOperado = strtotime("$Dias day", strtotime(fecha_iso_8601($Fecha_Ymd)));
        $fecha_es = strftime("%a, %d %b", $FechaUnixOperado);
        return utf8_encode($fecha_es);
    }
}

if (!function_exists('RestarSumarFecha')) {
    /*
     * @Fecha_Ymd => Parametro tipo string con formato d/m/y, fecha de salida elegida por el pasajeto
     * @Dias => Cantidad de dias a aumentar o restar.
     */

    function RestarSumarFecha($Fecha_Ymd, $Dias)
    {
        //        return fecha_iso_8601($Fecha_Ymd);
        $FechaUnixOperado = strtotime("$Dias day", strtotime(fecha_iso_8601($Fecha_Ymd)));
        return strftime("%d/%m/%Y", $FechaUnixOperado);
    }
}

if (!function_exists('SumarRestarHoras')) {

    function SumarRestarHoras($operador, $fecha, $hora)
    {
        $fecha_resultado = date('Y-m-d H:i:s', strtotime($fecha . " $operador" . $hora . ' hour'));
        return $fecha_resultado;
    }
}
if (!function_exists('ValidarFechaIda')) {

    function ValidarFechaIda($fechadmY, $date_to, $tipo_viaje)
    {
        if ($tipo_viaje === 'R') {
            $fecha_entrada = strtotime(fecha_iso_8601($fechadmY));
            $fecha_date_to = strtotime(fecha_iso_8601($date_to));
            $fecha_hoy_sistema = (new DateTime())->format('Y-m-d');
            $fecha_sistema = strtotime($fecha_hoy_sistema);
            if ($fecha_entrada > $fecha_date_to || $fecha_entrada < $fecha_sistema) {
                return 'disabled enlace_desactivado';
            } else {
                return 'enabled';
            }
        } else if ($tipo_viaje === 'O') {
            $fecha_entrada = strtotime(fecha_iso_8601($fechadmY));
            $fecha_hoy_sistema = (new DateTime())->format('Y-m-d');
            $fecha_sistema = strtotime($fecha_hoy_sistema);
            if ($fecha_entrada < $fecha_sistema) {
                return 'disabled enlace_desactivado';
            } else {
                return 'enabled';
            }
        }
    }
}
if (!function_exists('ValidarMuestraSabTarifaria')) {

    function ValidarMuestraSabTarifaria($fechadmY, $fecha_compara)
    {
        $fecha_entrada = strtotime(fecha_iso_8601($fechadmY));
        $fecha_compa = strtotime(fecha_iso_8601($fecha_compara));
        //        return $fechadmY . '|' . $fecha_compara;
        return ($fecha_entrada < $fecha_compa) ? 'disabled enlace_desactivado' : '';
    }
}

if (!function_exists('Fecha_dia_mes')) {

    function Fecha_dia_mes($datetime)
    {
        date_default_timezone_set('Europe/Madrid');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $fecha_es = strftime("%d %B ", strtotime(fecha_iso_8601($datetime)));
        return utf8_encode($fecha_es);
    }
}
if (!function_exists('ObtenerFecha')) {

    function ObtenerFecha($datetime)
    {
        date_default_timezone_set('America/Lima');
        return (new DateTime($datetime))->format('Y-m-d');
    }
}
if (!function_exists('CalcularDiferenciaDiaHoraVuelo')) {

    function CalcularDiferenciaDiaHoraVuelo($DepartureDateTime)
    {
        $format_date_iso = 'Y-m-d H:i:s';
        //        $format_date_test ='2019-01-24 14:09:00'; //TEST
        $hora_sistema = (new DateTime())->format($format_date_iso);
        $inicio = \DateTime::createFromFormat($format_date_iso, $hora_sistema);
        $final = \DateTime::createFromFormat($format_date_iso, $DepartureDateTime); //PROD
        //        $final = \DateTime::createFromFormat($format_date_iso, $format_date_test); //TEST
        $diff = $final->diff($inicio);
        $horas_diff = (int)$diff->format('%H');
        return (($inicio < $final) && ($horas_diff >= 3)) ? true : false;
        //        echo "Diferencia: " . $diff->format('%H horas, %i minutos') . "\n";
    }
}

if (!function_exists('RetornaHorasDiferencias')) {

    function RetornaHorasDiferencias($fecha_limite)
    {
        $fecha_hoy = strtotime(date('Y-m-d H:i:s'));
        $fecha_expira = strtotime($fecha_limite);
        return ($fecha_expira > $fecha_hoy) ? TRUE : FALSE;
    }
}

if (!function_exists('CantidadDeHorasPayPal')) {

    function CantidadDeHorasPayPal($fecha_hora_salida_ida)
    {
        //VALIDAR 72 HORAS //48 horas (actualizado)
        $ida = $fecha_hora_salida_ida;
        $hoy = date("Y-m-d H:i:s");
        $fecha_hoy = new DateTime($hoy);
        $fecha_ida = new DateTime($ida);
        //              echo $fecha_hoy;
        $diferencia = date_diff($fecha_hoy, $fecha_ida, true);
        $meses = $diferencia->format('%m');
        $dias = $diferencia->format('%d');
        $horas = $diferencia->format('%h');
        $tiempo = (int)$dias * 24 + (int)$horas;

        return ($tiempo <= 48 && $meses == 0) ? FALSE : TRUE;
        //        return $tiempo;
    }
}

if (!function_exists('GetFechaLimiteDeReserva')) {

    function GetFechaLimiteDeReserva()
    {
        $DatetTimeLimitReserva = new DateTime();
        $DatetTimeLimitReserva->modify('+3 hours');
        $fecha_limite = $DatetTimeLimitReserva->format('Y-m-d H:i:s');
        return $fecha_limite;
    }
}

