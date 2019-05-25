<?php

if (!function_exists('padata')) {

    function padata($xss_post, $PayPalReturnURL, $PayPalCancelURL, $pnr, $reserva_id, $total_pagar) {
        $cod_origen = $xss_post['cod_origen'];
        $cod_destino = $xss_post['cod_destino'];
        $ItemName = "Pasaje aereo $cod_origen-$cod_destino||$pnr"; //Item Name - RESERVA ORIGEN-DESTINO
        $ItemNumber = $reserva_id;
        $ItemQty = 1;
        $ItemPrice = $total_pagar;
        $PayPalCurrencyCode = 'USD';
        $padata = '&METHOD=SetExpressCheckout' .
                '&RETURNURL=' . urlencode($PayPalReturnURL) .
                '&CANCELURL=' . urlencode($PayPalCancelURL) .
                '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("Sale") .
                '&ADDROVERRIDE=1' . //EVITAR CAMBIO DE URL
                '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode("$ItemNumber") .
                '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                '&NOSHIPPING=1' . //EVITAR CAMBIO DE URL

                '&PAYMENTREQUEST_0_AMT=' . urlencode($ItemPrice) .
                '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
//                                '&INVNUM='.urlencode($codigo_reserva).
                '&LOCALECODE=PE' . //EN: PayPal pages to match the language on your website |  ES: PayPal para que coincida con el idioma de su sitio web.
                '&HDRIMG=https://sslzone.starperu.com/Vista/images/paypal_cabecera07.png' . //site logo
                '&CARTBORDERCOLOR=ffe633' . //border color of cart    
                '&ALLOWNOTE=1';
        return $padata;
    }

}

if (!function_exists('padata_DoExpressCheckoutPayment')) {

    function padata_DoExpressCheckoutPayment($token, $payer_id, $pnr, $reserva_id, $total_pagar, $pasajeros, $fechahora_salida_tramo_ida, $fechahora_llegada_tramo_retorno, $origen, $destino, $num_vuelo_ida, $num_vuelo_retorno, $clase_ida, $clase_retorno, $tipo_viaje) {

        $fecha_ida = ObtenerFecha($fechahora_salida_tramo_ida);
        $hora_ida = ObtenerHoraVuelo($fechahora_salida_tramo_ida);
        $fecha_retorno = ObtenerFecha($fechahora_llegada_tramo_retorno);
        $hora_retorno = ObtenerHoraVuelo($fechahora_llegada_tramo_retorno);

        $padata_do = '&TOKEN=' . urlencode($token) .
                '&PAYERID=' . urlencode($payer_id) .
                '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                //set item info here, oterwise we won't see product details later	
                '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($pnr) .
                '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($reserva_id) .
//				'&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc).
                '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($total_pagar) .
                '&L_PAYMENTREQUEST_0_QTY0=' . urlencode(1) .
                '&INVNUM=' . urlencode($reserva_id) .
                '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($total_pagar) .
                '&PAYMENTREQUEST_0_AMT=' . urlencode($total_pagar) .
                '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode('USD');

        $mensaje = "";
        $c = 0;

        foreach ($pasajeros->Result() as $pasajero) {
            $nombre = $pasajero->nombres . " " . $pasajero->apellidos;
//                                    $ticket = $pasajero["num_ticket"];
            $issuedate = str_replace("-", "", date('Y-m-d'));
            $traveldate_ida = str_replace("-", "", $fecha_ida);
            $traveldate_vuelta = str_replace("-", "", $fecha_retorno);
            $starperu = "2I";

            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_PASSENGERNAME=" . urlencode($nombre);
            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_ISSUEDATE=" . urlencode($issuedate);
            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_TICKETNUMBER=" . urlencode($pnr);
            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_TRAVELAGENCYNAME=" . urlencode("StarPeru");
            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_ISSUINGCARRIERCODE=" . urlencode($starperu);
            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_RESTRICTEDTICKET=" . urlencode("1");
            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_CLEARINGSEQUENCE=" . urlencode("1");
            $mensaje .= "&PAYMENTREQUEST_" . $c . "_AIRLINE_CLEARINGCOUNT=" . urlencode("1");

            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_SERVICECLASS0=" . urlencode("Y");
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_TRAVELDATE0=" . urlencode($traveldate_ida);
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_CARRIERCODE0=" . urlencode($starperu);
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_STOPOVERPERMITTED0=" . urlencode("0"); //escalas
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_DEPARTUREAIRPORT0=" . urlencode($origen);
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_ARRIVALAIRPORT0=" . urlencode($destino);
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_FLIGHTNUMBER0=" . urlencode($num_vuelo_ida);
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_DEPARTURETIME0=" . urlencode(ObtenerHoraMinuto($fechahora_salida_tramo_ida));
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_ARRIVALTIME00=" . urlencode(ObtenerHoraMinuto($fechahora_llegada_tramo_retorno));
            $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_FAREBASISCODE0=" . urlencode($clase_ida);

            if ($tipo_viaje == 'R') {
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_SERVICECLASS1=" . urlencode("Y");
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_TRAVELDATE1=" . urlencode($traveldate_vuelta);
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_CARRIERCODE1=" . urlencode($starperu);
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_STOPOVERPERMITTED1=" . urlencode("0"); //escalas
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_DEPARTUREAIRPORT1=" . urlencode($destino);
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_ARRIVALAIRPORT1=" . urlencode($origen);
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_FLIGHTNUMBER1=" . urlencode($num_vuelo_retorno);
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_DEPARTURETIME1=" . urlencode(ObtenerHoraMinuto($fechahora_llegada_tramo_retorno));
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_ARRIVALTIME1=" . urlencode(ObtenerHoraMinuto($fechahora_salida_tramo_ida));
                $mensaje .= "&L_PAYMENTREQUEST_" . $c . "_AIRLINE_LEG_FAREBASISCODE1=" . urlencode($clase_retorno);
            }
            $c = $c + 1;
        }
        $padata_do .= $mensaje;
        return $padata_do;
    }

}