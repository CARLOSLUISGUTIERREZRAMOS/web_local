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
        $data_insert['pnr'] = (string)$Itinerary->TravelItinerary->ItineraryRef->attributes()->ID;
        $data_insert['nombres'] = (string)$Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->PersonName->GivenName;
        $data_insert['apellidos'] = (string)$Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->PersonName->Surname;
        $tlfn_first = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone[0];
        $tlfn_second = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone[1];
        

        if (substr($tlfn_first, 0, 3) === 'LIM') {
            $tlfn = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone;

            $cant_tlfn_pax =  count($tlfn);
            if ($cant_tlfn_pax === 1) { 
                
                //Capturamos la data del primer telefono del pasajero
                $data_insert['ddi_telefono'] = '+51';
                $data_insert['pre_telefono'] = '51';
                $data_insert['num_telefono'] = substr($tlfn_first,3);
                $data_insert['nacionalidad'] = 43;  
            } else if ($cant_tlfn_pax === 2) { 
                //Capturamos la data del segundo telefono del pax
                $data_insert['ddi_telefono'] = '+51';
                $data_insert['pre_telefono'] = '51';
                $data_insert['num_telefono'] = substr($tlfn_second,3);
                $data_insert['nacionalidad'] = 43;  

            }
        } else if (substr($tlfn_first, 0, 3) === 'NET') {
            $data_get_tlfn1 = explode('D1', $tlfn_first)[1];
            $num_tlfn1 = explode('P1', $data_get_tlfn1);
            $data_insert['ddi_telefono'] = (string)'+' . $num_tlfn1[0];
            $data_insert['pre_telefono'] = (string)substr($num_tlfn1[1], 0, 2);
            $data_insert['num_telefono'] = (string)substr($num_tlfn1[1], 2);
            $data_get_tlfn2 = explode('D2', $tlfn_second)[1];
            $num_tlfn2 = explode('P2', $data_get_tlfn2);
            $data_insert['ddi_celular'] = (string)'+' . $num_tlfn2[0];
            $data_insert['pre_celular'] = (string)substr($num_tlfn2[1], 0, 2);
            $data_insert['num_celular'] = (string)substr($num_tlfn2[1], 2);
            $data_insert['nacionalidad'] = (empty($num_tlfn1)) ? (int)$CI->Pais_model->GetIdPais($num_tlfn2[0]) : (int)$CI->Pais_model->GetIdPais($num_tlfn1[0]);
        }

        
        
        $data_insert['tipo_documento'] = (string)$Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->Document->attributes()->DocType;
        $data_insert['num_documento'] = (string)$Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->Document->attributes()->DocID;
        $data_insert['email'] = (string)$Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Email[0];
        $data_insert['geo_ciudad'] = (string)GetDatosGeolocalizacion()['CIUDAD'];
        $data_insert['geo_pais'] = (string)GetDatosGeolocalizacion()['PAIS'];
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
            $data_insert['clase_ida'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->ResBookDesigCode;
            $data_insert['clase_retorno'] = "NULL";
            $data_insert['fechahora_salida_tramo_retorno'] = "NULL";
            $data_insert['fechahora_llegada_tramo_retorno'] = "NULL";
            $data_insert['num_vuelo_ida'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->FlightNumber;
            $data_insert['num_vuelo_retorno'] = "NULL";
        } else if ($tramos === 2) {
            $data_insert['tipo_viaje'] = 'R';
            $data_insert['fechahora_salida_tramo_ida'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->DepartureDateTime))->format('Y-m-d H:i:s');
            $data_insert['fechahora_llegada_tramo_ida'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->ArrivalDateTime))->format('Y-m-d H:i:s');
            $data_insert['clase_ida'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->ResBookDesigCode;
            $data_insert['clase_retorno'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->ResBookDesigCode;
            $data_insert['fechahora_salida_tramo_retorno'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->DepartureDateTime))->format('Y-m-d H:i:s');
            $data_insert['fechahora_llegada_tramo_retorno'] = (new DateTime($Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->ArrivalDateTime))->format('Y-m-d H:i:s');
            $data_insert['num_vuelo_ida'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->attributes()->FlightNumber;
            $data_insert['num_vuelo_retorno'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[1]->Air->Reservation->attributes()->FlightNumber;
        }

        $data_insert['origen'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->DepartureAirport->attributes()->LocationCode;
        $data_insert['destino'] = (string)$Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item[0]->Air->Reservation->ArrivalAirport->attributes()->LocationCode;
        $data_insert['eq'] = (double)$Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountBeforeTax;
        $data_insert['total'] = (double)$Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
        $data_insert['total_pagar'] = (double)$Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
        $Tax = $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Taxes;
        $taxes_array = GetTaxes($Tax);
        $data_insert['hw'] = $taxes_array['HW'];
        $data_insert['pe'] = $taxes_array['PE'];
        $data_insert['ruc'] = (isset($Itinerary->TravelItinerary->Remarks)) ? (string)$Itinerary->TravelItinerary->Remarks->Remark : "NULL";
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
if (!function_exists('ValidarDescuento')) {
    function ValidarDescuento($cod_origen,$cod_destino,$tipo_viaje,$rutas_set)
    {
                $valido = FALSE;
                $rutas_validas = explode(',',$rutas_set);
                $ruta_ida = $cod_origen.$cod_destino; // concatenamos las ruta para realizar la comnparacion
                $res_ida = in_array($ruta_ida,$rutas_validas);
                $valido = ($res_ida) ? TRUE : FALSE;
                if($tipo_viaje === 'R')
                {
                    $ruta_retorno = $cod_destino.$cod_origen;
                    $res_retorno = in_array($ruta_retorno,$rutas_validas);
                    $valido = ($res_retorno) ? TRUE : FALSE;
                }
                return $valido;
    }
}
