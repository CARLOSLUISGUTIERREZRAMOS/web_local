<?php

class CallAPIVisa extends CI_Controller {

    protected $visa;

    public function __construct() {
        parent::__construct();
        echo 2;die;
        $this->load->library('Visa/Connection_visa');
//        $rutaFile = FCPATH . "json\\visa_denegada.json";
//        $rutaFile = FCPATH . "json\\visa.json";
//        $rutaFile = FCPATH . "json\\visa_foranea.json";
//        $rutaFile = FCPATH . "json\\visa_quotas.json";
//        $rutaFile = FCPATH . "json\\visa_verified.json";
        $rutaFile = FCPATH . "json\\visa_denegado_verified.json";

        $this->load->model('Visa_model');
        $this->setRutaArchivo($rutaFile);
        $this->visa = new Connection_visa();
    }

    public function Index() {

        $archivo = $this->getRutaArchivo();
        $contenido_archivo = $this->ObtenerContenidoDeArchivo($archivo);
        $data_visa = json_decode($contenido_archivo, false);
//        die;
        $data = array(
            'reserva_id' => 1765963,
            'ecore_transaction_uiid' => $data_visa->header->ecoreTransactionUUID,
        );
        if(isset($data_visa->errorCode)){
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
            $data['eci_code'] = $data_visa->data->ECI;
            $data['action_code'] = $data_visa->data->ACTION_CODE;
            $data['card'] = $data_visa->data->CARD;
            $data['merchant'] = $data_visa->data->MERCHANT;
            $data['status'] = $data_visa->data->STATUS;
            $data['action_description'] = $data_visa->data->ACTION_DESCRIPTION;
            $data['adquiriente'] = $data_visa->data->ADQUIRENTE;
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

//        array_push($data, $push_order);
//        var_dump($data);

        $res = $this->Visa_model->GuardarTransaccion($data);
//        var_dump($res);
//        $timestamp =  $data_visa->order->transactionDate;
//        echo $data_visa->dataMap->ECI_DESCRIPTION;
    }

    public function ArmarBody() {
        $amount = 120.00;
        $request_body = "{ 
                \"amount\": $amount,
                \"channel\": \"web\",
                \"antifraud\": {
                    \"clientIp\" : \"191.98.147.210\",
                    \"merchantDefineData\" : {
                        \"MDD1\" : \"web\",
                        \"MDD2\" : \"Canl\",
                        \"MDD3\" : \"Canl\"
                    }
                }
        }";
        return $request_body;
    }

    public function Token() {

        $token = $this->visa->Connection();
        return $token;
    }

    protected function GetOtra() {
        $credentials = 'integraciones.visanet@necomplus.com:d5e7nk$M';
        $url = "https://apitestenv.vnforapps.com/api.security/v1/security";
        $page = "/api.security/v1/security";
        $headers = array(
            "POST " . $page . " HTTP/1.1",
            "Host: apitestenv.vnforapps.com",
//            "Content-type: text/xml;charset=\"utf-8\"", 
//            "Accept: text/xml", 
            "Cache-Control: no-cache",
//            "cache-control: no-cache", 
//            "SOAPAction: \"run\"", 
//            "Content-length: ".strlen($xml_data), 
            "Authorization: Basic " . base64_encode($credentials)
//            "Authorization: ,Basic aW50ZWdyYWNpb25lcy52aXNhbmV0QG5lY29tcGx1cy5jb206ZDVlN25rJE0="
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_USERAGENT, $defined_vars['HTTP_USER_AGENT']); 
        // Apply the XML to our curl call 
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data); 

        $data = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
            // Show me the result 
            var_dump($data);
            curl_close($ch);
        }
    }

    protected function CallAPI($method, $url, $data = false) {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    private function ObtenerContenidoDeArchivo($archivo) {
        return file_get_contents($archivo);
    }

    function setRutaArchivo($rutaArchivo) {
        $this->rutaArchivo = $rutaArchivo;
    }

    function getRutaArchivo() {
        return $this->rutaArchivo;
    }

}
