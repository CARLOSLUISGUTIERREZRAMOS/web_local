<?php

if (!function_exists('ArmarItinerario')) {

    function ArmarItinerario($xss_post) {

        $data_ida = explode('|', $xss_post['grupo_ida']);
        // Indice 1 => Hace referencia a la clase
        // Indice 2 => Hace referencia al numero de vuelo
        $clase_ida = $data_ida[1];
        $num_vuelo_ida = $data_ida[2];
        $fecha_hora_salida_ida = $data_ida[3];
        $fecha_hora_llegada_ida = $data_ida[4];

        switch ($xss_post['tipo_viaje']) {
            case 'R':
                $data_retorno = explode('|', $xss_post['grupo_retorno']);
                $clase_retorno = $data_retorno[1];
                $num_vuelo_retorno = $data_retorno[2];
                $fecha_hora_salida_retorno = $data_retorno[3];
                $fecha_hora_llegada_retorno = $data_retorno[4];
                $itinerario = array(array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$num_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => $xss_post['cod_origen'], 'ArrivalAirport' => $xss_post['cod_destino'], 'MarketingAirline' => "2I"),
                    array("DepartureDateTime" => "$fecha_hora_salida_retorno", "ArrivalDateTime" => "$fecha_hora_llegada_retorno", "FlightNumber" => "$num_vuelo_retorno", "ResBookDesigCode" => "$clase_retorno", "DepartureAirport" => $xss_post['cod_destino'], "ArrivalAirport" => $xss_post['cod_origen'], "MarketingAirline" => "2I"));
                break;
            case 'O':
                $itinerario = array(array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$num_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => $xss_post['cod_origen'], 'ArrivalAirport' => $xss_post['cod_destino'], 'MarketingAirline' => "2I"));
                break;
            default : echo "MOSTRAR MENSAJE DE ADVERTENCIA";
        }

        return $itinerario;
    }

}

if (!function_exists('ArmarItinerarioPagoReservas')) {

    function ArmarItinerarioPagoReservas($xss_post) {

        switch ($xss_post['tipo_viaje']) {
            case 'R':
                $itinerario = array(
                    array('DepartureDateTime' => $xss_post['fechahora_salida_tramo_ida'], 'ArrivalDateTime' => $xss_post['fechahora_llegada_tramo_ida'],
                        'FlightNumber' => $xss_post['num_vuelo_ida'], 'ResBookDesigCode' => $xss_post['clase_ida'],
                        'DepartureAirport' => $xss_post['origen'], 'ArrivalAirport' => $xss_post['destino'], 'MarketingAirline' => "2I"),
                    array("DepartureDateTime" => $xss_post['fechahora_salida_tramo_retorno'], "ArrivalDateTime" => $xss_post['fechahora_llegada_tramo_retorno'],
                        "FlightNumber" => $xss_post['num_vuelo_retorno'], "ResBookDesigCode" => $xss_post['clase_retorno'],
                        "DepartureAirport" => $xss_post['destino'], "ArrivalAirport" => $xss_post['origen'], "MarketingAirline" => "2I"));
                break;
            case 'O':
                $itinerario = array(
                    array('DepartureDateTime' => $xss_post['fechahora_salida_tramo_ida'], 'ArrivalDateTime' => $xss_post['fechahora_llegada_tramo_ida'],
                        'FlightNumber' => $xss_post['num_vuelo_ida'], 'ResBookDesigCode' => $xss_post['clase_ida'],
                        'DepartureAirport' => $xss_post['origen'], 'ArrivalAirport' => $xss_post['destino'], 'MarketingAirline' => "2I"));
                break;
            default : echo "MOSTRAR MENSAJE DE ADVERTENCIA";
        }

        return $itinerario;
    }

}


if (!function_exists('ObtenerCodigoCompartido')) {

    function ObtenerCodigoCompartido($xss_post) {

        $data_ida = explode('|', $xss_post['grupo_ida']);
        $codigo_compartido_ida = $data_ida[5];
        switch ($xss_post['tipo_viaje']) {
            case 'R':
                $codigo_compartido['ida'] = $codigo_compartido_ida;
                $data_retorno = explode('|', $xss_post['grupo_retorno']);
                $codigo_compartido['retorno'] = $data_retorno[5];
            case 'O':
                $codigo_compartido['ida'] = $codigo_compartido_ida;
        }

        return $codigo_compartido;
    }

}