<?php
if (!function_exists('FormarArregloInsert_ModuloPagoReservas')) {

    function FormarArregloInsert_ModuloPagoReservas($Itinerary)
    {

        $data_insert = [];
        $CI = &get_instance();
        $CI->load->library('Detector/Mobile_Detect');
        $CI->load->model('Pais_model');
        $detect = new Mobile_Detect();

        $data_insert['dispositivo'] = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
        $data_insert['pnr'] = (string) $Itinerary->TravelItinerary->ItineraryRef->attributes()->ID;
        $data_insert['nombres'] = (string) $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->PersonName->GivenName;
        $data_insert['apellidos'] = (string) $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->PersonName->Surname;
        $tlfn_first = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone[0];
        $tlfn_second = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone[1];


        if (substr($tlfn_first, 0, 3) === 'LIM') {
            $tlfn = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone;

            $cant_tlfn_pax =  count($tlfn);
            if ($cant_tlfn_pax === 1) {

                //Capturamos la data del primer telefono del pasajero
                $data_insert['ddi_telefono'] = '+51';
                $data_insert['pre_telefono'] = '51';
                $data_insert['num_telefono'] = substr($tlfn_first, 3);
                $data_insert['nacionalidad'] = 43;
            } else if ($cant_tlfn_pax === 2) {
                //Capturamos la data del segundo telefono del pax
                $data_insert['ddi_telefono'] = '+51';
                $data_insert['pre_telefono'] = '51';
                $data_insert['num_telefono'] = substr($tlfn_second, 3);
                $data_insert['nacionalidad'] = 43;
            }
        } else if (substr($tlfn_first, 0, 3) === 'NET') {
            $data_get_tlfn1 = explode('D1', $tlfn_first)[1];
            $num_tlfn1 = explode('P1', $data_get_tlfn1);
            $data_insert['ddi_telefono'] = (string) '+' . $num_tlfn1[0];
            $data_insert['pre_telefono'] = (string) substr($num_tlfn1[1], 0, 2);
            $data_insert['num_telefono'] = (string) substr($num_tlfn1[1], 2);
            $data_get_tlfn2 = explode('D2', $tlfn_second)[1];
            $num_tlfn2 = explode('P2', $data_get_tlfn2);
            $data_insert['ddi_celular'] = (string) '+' . $num_tlfn2[0];
            $data_insert['pre_celular'] = (string) substr($num_tlfn2[1], 0, 2);
            $data_insert['num_celular'] = (string) substr($num_tlfn2[1], 2);
            $data_insert['nacionalidad'] = (empty($num_tlfn1)) ? (int) $CI->Pais_model->GetIdPais($num_tlfn2[0]) : (int) $CI->Pais_model->GetIdPais($num_tlfn1[0]);
        }



        $data_insert['tipo_documento'] = (string) $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->Document->attributes()->DocType;
        $data_insert['num_documento'] = (string) $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->Document->attributes()->DocID;
        $data_insert['email'] = (string) $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Email[0];
        $data_insert['geo_ciudad'] = (string) GetDatosGeolocalizacion()['CIUDAD'];
        $data_insert['geo_pais'] = (string) GetDatosGeolocalizacion()['PAIS'];
        $data_insert['fecha_registro'] = date('Y-m-d H:i:s');
        $tiempo_limite_reserva_kiu = $Itinerary->TravelItinerary->ItineraryInfo->Ticketing->attributes()->TicketTimeLimit;
        $fecha_limite = (new DateTime($tiempo_limite_reserva_kiu))->format('Y-m-d H:i:s');
        $data_insert['fecha_limite'] = $fecha_limite;
        $array_cant_pax = GetCantTipoPax($Itinerary->TravelItinerary->CustomerInfos);

        $data_insert['cant_adl'] = $array_cant_pax['ADT'];
        $data_insert['cant_chd'] = $array_cant_pax['CHD'];
        $data_insert['cant_inf'] = $array_cant_pax['INF'];

        $tramos = count($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item);

        if ($tramos === 1) {
            $data_insert['tipo_viaje'] = 'O';
            $data_insert['fechahora_salida_tramo_ida'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->DepartureDateTime))->format('Y-m-d');
            $data_insert['fechahora_llegada_tramo_ida'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->ArrivalDateTime))->format('Y-m-d H:i:s');
            $data_insert['clase_ida'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->ResBookDesigCode;
            $data_insert['clase_retorno'] = "NULL";
            $data_insert['fechahora_salida_tramo_retorno'] = "NULL";
            $data_insert['fechahora_llegada_tramo_retorno'] = "NULL";
            $data_insert['num_vuelo_ida'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->FlightNumber;
            $data_insert['num_vuelo_retorno'] = "NULL";
        } else if ($tramos === 2) {
            $data_insert['tipo_viaje'] = 'R';
            $data_insert['fechahora_salida_tramo_ida'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->DepartureDateTime))->format('Y-m-d H:i:s');
            $data_insert['fechahora_llegada_tramo_ida'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->ArrivalDateTime))->format('Y-m-d H:i:s');
            $data_insert['clase_ida'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->ResBookDesigCode;
            $data_insert['clase_retorno'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->ResBookDesigCode;
            $data_insert['fechahora_salida_tramo_retorno'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->DepartureDateTime))->format('Y-m-d H:i:s');
            $data_insert['fechahora_llegada_tramo_retorno'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->ArrivalDateTime))->format('Y-m-d H:i:s');
            $data_insert['num_vuelo_ida'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->FlightNumber;
            $data_insert['num_vuelo_retorno'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->FlightNumber;
        }

        $data_insert['origen'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->DepartureAirport->attributes()->LocationCode;
        $data_insert['destino'] = (string) $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->ArrivalAirport->attributes()->LocationCode;
        $data_insert['eq'] = (float) $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountBeforeTax;
        $data_insert['total'] = (float) $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
        $data_insert['total_pagar'] = (float) $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
        $Tax = $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Taxes;
        $taxes_array = GetTaxes($Tax);
        $data_insert['hw'] = $taxes_array['HW'];
        $data_insert['pe'] = $taxes_array['PE'];
        $data_insert['ruc'] = (isset($Itinerary->TravelItinerary->Remarks)) ? (string) $Itinerary->TravelItinerary->Remarks->Remark : "NULL";
        $data_insert['ip'] = ip2long($_SERVER['REMOTE_ADDR']);


        return $data_insert;
    }
}
if (!function_exists('GetClase')) {
    function GetClase($arg)
    {
        $clase = [];
        $tipo_viaje = $arg['tipo_viaje'];
        $data_ida = explode('|', $arg['grupo_ida']);
        $clase['ida'] = $data_ida[1];
        if ($tipo_viaje === 'R') {
            $data_retorno = explode('|', $arg['grupo_retorno']);
            $clase['retorno'] = $data_retorno[1];
        }
        return $clase;
    }
}
if (!function_exists('GetNumeroVuelo')) {
    function GetNumeroVuelo($arg)
    {
        $num_vuelo = [];
        $tipo_viaje = $arg['tipo_viaje'];
        $data_ida = explode('|', $arg['grupo_ida']);
        $num_vuelo['ida'] = $data_ida[2];
        if ($tipo_viaje === 'R') {
            $data_retorno = explode('|', $arg['grupo_retorno']);
            $num_vuelo['retorno'] = $data_retorno[2];
        }
        return $num_vuelo;
    }
}


if (!function_exists('ValidarDescuento')) {
    function ValidarDescuento($cod_origen, $cod_destino, $tipo_viaje, $rutas_set)
    {
        $valido = FALSE;
        $rutas_validas = explode(',', $rutas_set);
        $ruta_ida = $cod_origen . $cod_destino; // concatenamos las ruta para realizar la comnparacion
        $res_ida = in_array($ruta_ida, $rutas_validas);
        $valido = ($res_ida) ? TRUE : FALSE;
        if ($tipo_viaje === 'R') {
            $ruta_retorno = $cod_destino . $cod_origen;
            $res_retorno = in_array($ruta_retorno, $rutas_validas);
            $valido = ($res_retorno) ? TRUE : FALSE;
        }
        return $valido;
    }
}
if (!function_exists('ValidarAerolineaDescuento')) {
    function ValidarAerolineaDescuento($tipo_viaje, $num_flight, $objAerolinea)
    {
        $obj_aerolinea_val_array = explode(',', $objAerolinea);
        if ($tipo_viaje === 'O') {
            $compania_ida = (strlen($num_flight['ida']) === 3) ? 'P9' : '2I';
            $valido_ida = in_array($compania_ida, $obj_aerolinea_val_array);
            return $valido_ida;
        } else if ($tipo_viaje === 'R') {
            $compania_ida = (strlen($num_flight['ida']) === 3) ? 'P9' : '2I';
            $compania_retorno = (strlen($num_flight['retorno']) === 3) ? 'P9' : '2I';
            $valido_ida = in_array($compania_ida, $obj_aerolinea_val_array);
            $valido_retorno = in_array($compania_retorno, $obj_aerolinea_val_array);
            if ($valido_ida && $valido_retorno) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}
if (!function_exists('FormarArrayVistaBooking2')) {
    function FormarArrayVistaBooking2($xss_post, $data)
    {
        $data['cant_adl'] = (int) $xss_post['cant_adl'];
        $data['cant_chd'] = (int) $xss_post['cant_chd'];
        $data['cant_inf'] = (int) $xss_post['cant_inf'];
        $data['grupo_ida'] = $xss_post['grupo_ida'];

        $data['datetime_departure'] = explode('|', $data['grupo_ida'])[3];
        $data['tipo_viaje'] = $xss_post['tipo_viaje'];
        $data['cod_origen'] = $xss_post['cod_origen'];
        $data['cod_destino'] = $xss_post['cod_destino'];
        $data['geoip_pais'] = $xss_post['geoip_pais'];
        $data['geoip_ciudad'] = $xss_post['geoip_ciudad'];
        $data['grupo_retorno'] = '';
        if ($xss_post['tipo_viaje'] === 'R') :
            $data['grupo_retorno'] = $xss_post['grupo_retorno'];
        endif;
        return $data;
    }
}

if (!function_exists('FormarArregloInsertTblReserva')) {

    function FormarArregloInsertTblReserva($xss_post,$JsonDataVuelo,$codigo_compartido,$transaccion_movil,$fecha_limite,$res_tarifa_tax,$pnr,$id_descuento,$precio_total_sin_descuento)
    { 
        if (empty($xss_post['num_tlfn'])) {
            $xss_post['num_telefono'] = "NULL";
            $xss_post['ddi_pais_tlfn'] = "NULL";
            $xss_post['region_tlfn'] = "NULL";
        }
        if (empty($xss_post['num_cel'])) {
            $xss_post['num_celular'] = "NULL";
            $xss_post['ddi_pais_cel'] = "NULL";
            $xss_post['region_cel'] = "NULL";
        }
        if (empty($xss_post['num_cel'])) {
            $xss_post['num_celular'] = "NULL";
            $xss_post['ddi_pais_cel'] = "NULL";
            $xss_post['region_cel'] = "NULL";
        }
        $data_reserva_insert = array(
            'nombres' => $xss_post['nombres_adl_1'],
            'apellidos' => $xss_post['apellidos_adl_1'],
            'nacionalidad' => $xss_post['nacionalidad_adl_1'],
            'tipo_documento' => $xss_post['tipo_documento_adl_1'],
            'num_documento' => $xss_post['numdoc_adl_1'],
            'ddi_telefono' => $xss_post['ddi_pais_tlfn'],
            'pre_telefono' => $xss_post['region_tlfn'],
            'num_telefono' => $xss_post['num_tlfn'],
            'ddi_celular' => $xss_post['ddi_pais_cel'],
            'pre_celular' => $xss_post['region_cel'],
            'num_celular' => $xss_post['num_cel'],
            'cc_code' => $xss_post['cc_code'],
            'email' => $xss_post['email'],
            'ip' => ip2long($_SERVER['REMOTE_ADDR']),
            'geo_pais' => $xss_post['geoip_pais'],
            'geo_ciudad' => $xss_post['geoip_ciudad'],
            'ruc' => (empty($xss_post['ruc'])) ? "NULL" : $xss_post['ruc'],
            'cant_adl' => $xss_post['cant_adl'],
            'cant_chd' => $xss_post['cant_chd'],
            'cant_inf' => $xss_post['cant_inf'],
            'tipo_viaje' => $xss_post['tipo_viaje'],
            'clase_ida' => $JsonDataVuelo->clase_ida,
            'clase_retorno' => $JsonDataVuelo->clase_retorno,
            'num_vuelo_ida' => $JsonDataVuelo->num_vuelo_ida,
            'cod_compartido_vuelo_ida' => $codigo_compartido['ida'],
            'dispositivo' => ($transaccion_movil) ? 'app ' : $xss_post['dispositivo'],
            'num_vuelo_retorno' => $JsonDataVuelo->num_vuelo_retorno,
            'cod_compartido_vuelo_retorno' => (isset($codigo_compartido['retorno'])) ? $codigo_compartido['ida'] : NULL,
            'fecha_registro' => (new DateTime())->format('Y-m-d H:i:s'),
            'fecha_limite' => $fecha_limite,
            'fechahora_salida_tramo_ida' => $JsonDataVuelo->fechahora_salida_tramo_ida,
            'fechahora_llegada_tramo_ida' => $JsonDataVuelo->fechahora_llegada_tramo_ida,
            'fechahora_salida_tramo_retorno' => ($JsonDataVuelo->fechahora_salida_tramo_retorno == 'NULL') ? NULL : $JsonDataVuelo->fechahora_salida_tramo_retorno,
            'fechahora_llegada_tramo_retorno' => ($JsonDataVuelo->fechahora_llegada_tramo_retorno == 'NULL') ? NULL : $JsonDataVuelo->fechahora_llegada_tramo_retorno,
            'origen' => $xss_post['cod_origen'],
            'destino' => $xss_post['cod_destino'],
            'pnr' => $pnr,
            'total_pagar' => $res_tarifa_tax->TOTAL_PAGAR,
            'total' => (isset($precio_total_sin_descuento) && !empty($precio_total_sin_descuento)) ? $precio_total_sin_descuento : $res_tarifa_tax->TOTAL_PAGAR,
            'descuento_id' => $id_descuento,
            'eq' => $res_tarifa_tax->EQ,
            'hw' => $res_tarifa_tax->HW,
            'pe' => $res_tarifa_tax->PE,
        );
        return $data_reserva_insert;
    }
}
