<?php

if (!function_exists('ObtenerCodigoDocIdentidad')) {

    function ObtenerCodigoDocIdentidad($tipo_doc_web) {
        switch ($tipo_doc_web) {
            case 'NI':
                $documentType = 0;
                break;
            case 'ID':
                $documentType = 1;
                break;
            case 'PP':
                $documentType = 2;
                break;
            default : 'Documento indefinido';
        }
        return $documentType;
    }

}

if (!function_exists('ArmarDataFormVisa')) {

    function ArmarDataFormVisa($sessionKey, $total_pagar, $cod_comercio, $tipo_doc_pax, $num_doc, $id_reserva,$libreriaJsVisa) {
        $data_visa['session_key'] = $sessionKey;
        $data_visa['TOTALPAGAR'] = $total_pagar;
        $data_visa['codigo_comercio'] = $cod_comercio;
        $data_visa['documentType'] = $tipo_doc_pax;
        $data_visa['documentNumber'] = $num_doc;
        $data_visa['id_reserva'] = $id_reserva;
        $data_visa['libreriaJsVisa'] = $libreriaJsVisa;
        return $data_visa;
    }

}

if (!function_exists('ArmarDataSessionZonaPagoApiVisa')) {

    function ArmarDataSessionZonaPagoApiVisa($token,$id_reserva) {

        $data_session = array(
            'token_seguridad_visa' => $token,
            'id_reserva' => $id_reserva
        );

        return $data_session;
    }

}

if (!function_exists('ArmarDataParaInsertar')) {

    function ArmarDataParaInsertar($data_ws_visa, $reserva_id) {

        $data_visa = json_decode($data_ws_visa, false);
        $data = array(
            'reserva_id' => $reserva_id,
            'ecore_transaction_uiid' => $data_visa->header->ecoreTransactionUUID,
        );

        if (isset($data_visa->errorCode)) {
            $data['action_code'] = $data_visa->errorCode;
            $data['action_description'] = $data_visa->errorMessage;
        }
        if (isset($data_visa->order)) {
//            $data['reserva_id'] = $data_visa->order->purchaseNumber;
            $data['token_id'] = $data_visa->order->tokenId;
            $data['purchase_number'] = $data_visa->order->purchaseNumber;
            $data['amount'] = $data_visa->order->amount;
            $data['authorized_amount'] = $data_visa->order->authorizedAmount;
            $data['authorization_code'] = $data_visa->order->authorizationCode;
            $data['transaction_date'] = $data_visa->order->transactionDate;
            $data['transaction_id'] = $data_visa->order->transactionId;
        }
        if (isset($data_visa->data)) {

            $data['brand'] = $data_visa->data->BRAND;
            $data['eci_code'] = (!isset($data_visa->data->ECI))? '' : $data_visa->data->ECI; ;
            $data['action_code'] = $data_visa->data->ACTION_CODE;
            $data['card'] = (!isset($data_visa->data->CARD)) ? '': $data_visa->data->CARD;
            $data['merchant'] = $data_visa->data->MERCHANT;
            $data['status'] = $data_visa->data->STATUS;
            $data['action_description'] = $data_visa->data->ACTION_DESCRIPTION;
            $data['adquiriente'] = (!isset($data_visa->data->ADQUIRENTE)) ? '' : $data_visa->data->ADQUIRENTE;
            $data['amount'] = $data_visa->data->AMOUNT;
        } else if (isset($data_visa->dataMap)) {
            $data['brand'] = $data_visa->dataMap->BRAND;
            $data['eci_code'] = $data_visa->dataMap->ECI;
            $data['action_code'] = $data_visa->dataMap->ACTION_CODE;
            $data['card'] = $data_visa->dataMap->CARD;
            $data['merchant'] = $data_visa->dataMap->MERCHANT;
            $data['status'] = $data_visa->dataMap->STATUS;
            $data['action_description'] = $data_visa->dataMap->ACTION_DESCRIPTION;
            $data['adquiriente'] = $data_visa->dataMap->ADQUIRENTE;
            $data['quota_amount'] = (isset($data_visa->dataMap->QUOTA_AMOUNT)) ? $data_visa->dataMap->QUOTA_AMOUNT : NULL;
            $data['quota_number'] = (isset($data_visa->dataMap->QUOTA_NUMBER)) ? $data_visa->dataMap->QUOTA_NUMBER : NULL;
            $data['id_unico'] = $data_visa->dataMap->ID_UNICO;
            $data['quota_deferred'] = (isset($data_visa->dataMap->QUOTA_DEFERRED)) ? $data_visa->dataMap->QUOTA_DEFERRED : NULL;
        }

        return $data;
    }

}