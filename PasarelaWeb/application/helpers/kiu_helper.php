<?php

if (!function_exists('ArmarTramaTipoCredito_DemandTicket')) {

    function ArmarTramaTipoCredito_DemandTicket($miscellaneous, $PaymentType, $reserva_id, $pnr, $ruc, $cod_autcard, $card_number)
    {

        $trama = array(
            'PaymentType' => "$PaymentType",
            'CreditCardCode' => "$miscellaneous",
            'CreditCardNumber' => str_replace('*', '0', $card_number),
            'CreditSeriesCode' => $cod_autcard,
            'CreditExpireDate' => "9999",
            'Country' => "PE",
            'Currency' => "USD",
            'TourCode' => "",
            'BookingID' => trim($pnr),
            'InvoiceCode' => "ACME",
            'VAT' => $ruc
        );
        return $trama;
    }
}
if (!function_exists('ArmarTramaTipoMiscelaneo_DemandTicket')) {

    function ArmarTramaTipoMiscelaneo_DemandTicket($miscellaneous, $PaymentType, $reserva_id, $pnr, $ruc)
    {

        $trama = array(
            'PaymentType' => "$PaymentType",
            'MiscellaneousCode' => "$miscellaneous",
            'InvoiceCode' => "ACME",
            'Country' => "PE",
            'Currency' => "USD",
            'TourCode' => "",
            'BookingID' => trim($pnr),
            'InvoiceCode' => "ACME",
            'Text' => $reserva_id,
            'VAT' => $ruc
        );
        return $trama;
    }
}
if (!function_exists('ArmaTrama_TravelItinerary')) {

    function ArmaTrama_TravelItinerary($ticket, $email_pax)
    {

        $trama = array('IdTicket' => $ticket, 'Email' => $email_pax);

        return $trama;
    }
}
if (!function_exists('GetCantTipoPax')) {

    function GetCantTipoPax($NodoCustomerInfos)
    {
        $cant = [];
        $cant['ADT'] = 0;
        $cant['CHD'] = 0;
        $cant['INF'] = 0;
        foreach ($NodoCustomerInfos->CustomerInfo as $CustomerInfo) {
            $tipo_pax = (string)$CustomerInfo->Customer->attributes()->PassengerTypeCode;
            
            switch ($tipo_pax) {
                case "ADT":
                    $cant['ADT']++;
                    break;
                case "CNN":
                    $cant['CHD']++;
                    break;
                case "INF":
                    $cant['INF']++;
                    break;
            }
        }
        
        return $cant;
        
    }
}
if (!function_exists('GetTaxes')) {

    function GetTaxes($NodoItineraryPricing)
    {   
        
        $taxes = [];
        foreach($NodoItineraryPricing->Tax as $Tax){
            switch((string)$Tax->attributes()->TaxCode){
                case "HW":
                    $taxes['HW'] = (double)$Tax->attributes()->Amount;
                    break;
                    case "PE":
                    $taxes['PE'] = (double)$Tax->attributes()->Amount;
                    break;
            }
        }
        return $taxes; 
    }
}