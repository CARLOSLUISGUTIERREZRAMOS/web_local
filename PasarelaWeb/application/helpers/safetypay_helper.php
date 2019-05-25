<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function hash_signature($Data) {
    $signature = hash('sha256', $Data, false); //false para que devuelva en hexadecimal
    $finalhash = strtoupper($signature);
    return $finalhash;
}

function Retonar_Estado($status) {
    switch ($status) {
        case "000":$status = "";
            break;
        case "101":$status = "Transacción creada.";
            break;
        case "102":$status = "SafetyPay recibe la confirmación del pago de un Banco Asociado.";
            break;
        case "104":$status = "Pago de la transacción fue notificada al Comercio.";
            break;
        case "105":$status = "Comercio envió compra.";
            break;
        case "106":$status = "SafetyPay solicita pago al Comercio.";
            break;
        case "107":$status = "SafetyPay confirma que Comercio recibió pago.";
            break;
        case "201":$status = "Comercio solicita devolución.";
            break;
        case "202":$status = "SafetyPay acepta devolución al Comprador.";
            break;
        case "203":$status = "SafetyPay deniega solicitud de devolución.";
            break;
        case "204":$status = "SafetyPay solicita a Banco el retorno del monto a devolver al Comprador.";
            break;
        case "205":$status = "SafetyPay confirma al Comprador que recibió monto de devolución.";
            break;
        case "206":$status = "SafetyPay solicita el débito al Comercio del monto de devolución.";
            break;
        case "207":$status = "SafetyPay confirma débito al Comercio del monto de devolución.";
            break;
        case "301":$status = "Solicitud de Reclamo realizado por Comprador o Banco.";
            break;
        case "302":$status = "Reclamo Aprobado.";
            break;
        case "303":$status = "Reclamo Denegado.";
            break;
        case "304":$status = "Solicitud del Banco para retornar el monto en reclamo al Comprador.";
            break;
        case "305":$status = "SafetyPay confirma al Comprador que recibió el monto en reclamo.";
            break;
        case "306":$status = "SafetyPay solicita débito al Comercio del monto en reclamo.";
            break;
        case "307":$status = "SafetyPay confirma débito al Comercio del monto en reclamo.";
            break;
        default:$status = "Campo Vacio";
            break;
    }
    return $status;
}

function ArmarDataCreateExpressToken($apikey, $RequestDateTime, $CurrencyCode, $Amount, $MerchantSalesID, $Language, $TrackingCode, $ExpirationTime, $TransactionOkURL, $TransactionErrorURL, $ExpirationTime, $xss_post, $SignatureHash) {

    $Mensaje = array(
        'ApiKey' => $apikey,
        'RequestDateTime' => $RequestDateTime,
        'CurrencyCode' => $CurrencyCode,
        'Amount' => $Amount,
        'MerchantSalesID' => $MerchantSalesID,
        'Language' => $Language,
        'TrackingCode' => $TrackingCode,
        'ExpirationTime' => (int) $ExpirationTime,
        'FilterBy' => "",
        'TransactionOkURL' => $TransactionOkURL,
        'TransactionErrorURL' => $TransactionErrorURL,
        'TransactionExpirationTime' => (int) $ExpirationTime,
        'CustomMerchantName' => "STAR PERU",
        'ShopperEmail' => $xss_post['email'],
        'ProductID' => "1",
        'ShopperInformation_first_name' => $xss_post['nombres_adl_1'],
        'ShopperInformation_last_name' => $xss_post['apellidos_adl_1'],
        'ShopperInformation_email' => $xss_post['email'],
        'ShopperInformation_country_code' => $xss_post['ddi_pais_tlfn'],
        'ShopperInformation_mobile' => $xss_post['num_cel'],
        'ResponseFormat' => "XML",
        'Signature' => $SignatureHash
    );

    return $Mensaje;
}

function ArmarDataRespuestaLogSafetypay($reserva_id, $array_respuesta) {
    $data_log_safetypay_insert = array(
        'reserva_id' => $reserva_id,
        'respuesta' => $array_respuesta[1],
        'codigo_error' => $array_respuesta[0]["ExpressTokenResponse"]["ErrorManager"]["ErrorNumber"],
        'mensaje_error' => $array_respuesta[0]["ExpressTokenResponse"]["ErrorManager"]["Description"],
    );

    return $data_log_safetypay_insert;
}

function actualizar_respuesta_safetypay($MerchantSalesID, $ApiKey, $ResponseDateTime, $ReferenceNo, $CreationDateTime, $Amount, $CurrencyID, $PaymentReferenceNo, $Status, $estado_total, $ip) {
    $datos = explode("-", $MerchantSalesID);
    $id_reserva = $datos[1];


    $Campos_Post = '';
    $Campos_Post .= 'POST recibido:';
    $Campos_Post .= 'ApiKey =>' . $ApiKey . ', ';
    $Campos_Post .= 'RequestDateTime =>' . $ResponseDateTime . ', ';
    $Campos_Post .= 'MerchantSalesID =>' . $MerchantSalesID . ', ';
    $Campos_Post .= 'ReferenceNo =>' . $ReferenceNo . ', ';
    $Campos_Post .= 'CreationDateTime =>' . $CreationDateTime . ', ';
    $Campos_Post .= 'Amount =>' . $Amount . ', ';
    $Campos_Post .= 'CurrencyID =>' . $CurrencyID . ', ';
    $Campos_Post .= 'PaymentReferenceNo =>' . $PaymentReferenceNo . ', ';
    $Campos_Post .= 'Status =>' . $Status . ', ';

    $Campos_Respuesta = '';
    $Campos_Respuesta .= 'Campos enviados:';
    $Campos_Respuesta .= 'ErrorNumber =>' . 'Sin error' . ', ';
    $Campos_Respuesta .= 'ResponseDateTime =>' . $ResponseDateTime . ', ';
    $Campos_Respuesta .= 'MerchantSalesID =>' . $MerchantSalesID . ', ';
    $Campos_Respuesta .= 'ReferenceNo =>' . $ReferenceNo . ', ';
    $Campos_Respuesta .= 'CreationDateTime =>' . $CreationDateTime . ', ';
    $Campos_Respuesta .= 'Amount =>' . $Amount . ', ';
    $Campos_Respuesta .= 'CurrencyID =>' . $CurrencyID . ', ';
    $Campos_Respuesta .= 'PaymentReferenceNo =>' . $PaymentReferenceNo . ', ';
    $Campos_Respuesta .= 'Status =>' . $Status . ', ';
    $Campos_Respuesta .= 'OrderNo =>' . $MerchantSalesID . ', ';
    $FechaConfirmacion = date("Y-m-d H:i:s");

    $data = array(
        'campos_post' => $Campos_Post,
        'campos_respuesta' => $Campos_Respuesta,
        'codigo_estado' => $Status,
        'descripcion_estado' => $estado_total,
        'fecha_confirmacion' => $FechaConfirmacion,
        'ip_cliente' => $ip,
        'reserva_id' => $id_reserva
    );

    return $data;
}

function Campos_post_Safetypay($MerchantSalesID, $ApiKey, $ResponseDateTime, $ReferenceNo, $CreationDateTime, $Amount, $CurrencyID, $PaymentReferenceNo, $Status) {
    $datos = explode("-", $MerchantSalesID);
    $id_reserva = $datos[1];

    $Campos_Post = '';
    $Campos_Post .= 'POST recibido:';
    $Campos_Post .= 'ApiKey =>' . $ApiKey . ', ';
    $Campos_Post .= 'RequestDateTime =>' . $ResponseDateTime . ', ';
    $Campos_Post .= 'MerchantSalesID =>' . $MerchantSalesID . ', ';
    $Campos_Post .= 'ReferenceNo =>' . $ReferenceNo . ', ';
    $Campos_Post .= 'CreationDateTime =>' . $CreationDateTime . ', ';
    $Campos_Post .= 'Amount =>' . $Amount . ', ';
    $Campos_Post .= 'CurrencyID =>' . $CurrencyID . ', ';
    $Campos_Post .= 'PaymentReferenceNo =>' . $PaymentReferenceNo . ', ';
    $Campos_Post .= 'Status =>' . $Status . ', ';
    $data = array(
        'reserva_id' => $id_reserva,
        'campos_post' => $Campos_Post
    );
    return $data;
}

function Campos_respuesta_Safetypay($MerchantSalesID, $ResponseDateTime, $ReferenceNo, $CreationDateTime, $Amount, $CurrencyID, $PaymentReferenceNo, $Status) {
    $datos = explode("-", $MerchantSalesID);
    $id_reserva = $datos[1];

    $Campos_Respuesta = '';
    $Campos_Respuesta .= 'Campos enviados:';
    $Campos_Respuesta .= 'ErrorNumber =>' . 'Sin error' . ', ';
    $Campos_Respuesta .= 'ResponseDateTime =>' . $ResponseDateTime . ', ';
    $Campos_Respuesta .= 'MerchantSalesID =>' . $MerchantSalesID . ', ';
    $Campos_Respuesta .= 'ReferenceNo =>' . $ReferenceNo . ', ';
    $Campos_Respuesta .= 'CreationDateTime =>' . $CreationDateTime . ', ';
    $Campos_Respuesta .= 'Amount =>' . $Amount . ', ';
    $Campos_Respuesta .= 'CurrencyID =>' . $CurrencyID . ', ';
    $Campos_Respuesta .= 'PaymentReferenceNo =>' . $PaymentReferenceNo . ', ';
    $Campos_Respuesta .= 'Status =>' . $Status . ', ';
    $Campos_Respuesta .= 'OrderNo =>' . $MerchantSalesID . ', ';
    $FechaConfirmacion = date("Y-m-d H:i:s");

    $data = array(
        'reserva_id' => $id_reserva,
        'campos_respuesta' => $Campos_Respuesta,
        'fecha_confirmacion' => $FechaConfirmacion,
    );
    return $data;
}
