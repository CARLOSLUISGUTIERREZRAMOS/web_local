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
        $data_ida = explode('|',$arg['grupo_ida']);
        $clase['ida'] = $data_ida[1];
        if($tipo_viaje === 'R') 
        {
            $data_retorno= explode('|',$arg['grupo_retorno']);
            $clase['retorno'] = $data_retorno[1];
        }
        return $clase;
    }
}
