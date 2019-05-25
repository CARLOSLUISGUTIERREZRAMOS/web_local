<?php

if (!defined('BASEPATH'))
    exit('No direct script accesss allowed');

class Connection_pago_efectivo {
    
    
    protected $id_service = 98;  //SIEMPRE

//    protected $endpoint = 'services.pagoefectivo.pe';//PROD
//    protected $endpoint_solicitud = 'http://services.pagoefectivo.pe/v1/authorizations';
//    protected $endpoint_cip = 'http://services.pagoefectivo.pe/v1/cips';
//    protected $accessKey = 'ZDQ5MTM3MDdkODA4MzYx';
//    protected $secretKey = 'ZlU80uca4wPpzOjqn/vTNN3CINh+X7HK';
    
    
    protected $endpoint = 'pre1a.services.pagoefectivo.pe';
    protected $endpoint_solicitud = 'http://pre1a.services.pagoefectivo.pe/v1/authorizations';
    protected $endpoint_cip = 'http://pre1a.services.pagoefectivo.pe/v1/cips';
    protected $accessKey = 'OGU1ODNkNTlhZDcxNTQ4';
    protected $secretKey = 'XqP7eBlS6XE9tyArQka+C4mXWy72KySE8Nh4t1/a';
    

    public function __construct() {
        
    }

    public function GeneraBody($accessKey, $id_service, $dateRequest, $hashstring) {
        $request_body = "{ 
                \"accessKey\": \"$accessKey\",
                \"idService\": \"$id_service\",
                \"dateRequest\": \"$dateRequest\",
                \"hashString\": \"$hashstring\"
                
        }";
        return $request_body;
    }

    public function GeneraSolicitud($body) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->endpoint_solicitud",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "$body",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: a236b899-1c9c-459e-ad89-63b999848586",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
    
//    public function GeneraHeaderCIP($tokenPE, $id_service, $dateRequest, $hashstring) {
//        $request_body_cip = "{ 
//                \"Accept-Language\": \" es-PE\",
//                \"Authorization :Bearer $tokenPE,
//                \"Content-Type\": \"application/json\",
//                \"Origin\": web,
//                \"Postman-Token\": \"4f8e34c4-1192-4247-b346-7c5556772db3\",
//                \"cache-control\": \"no-cache\"
//                
//        }";
//        return $request_body_cip;
//    }

    public function GeneraHeaderCIP($TotalPagar,$tokenPE, $xss_post, $reserva_id ) {
//        return $this->GeneraBodyCIP($TotalPagar, $xss_post, $reserva_id);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->endpoint_cip",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->GeneraBodyCIP($TotalPagar, $xss_post, $reserva_id),
            CURLOPT_HTTPHEADER => array(
                "Accept-Language: es-PE",
                "Authorization: Bearer " . $tokenPE,
                "Content-Type: application/json",
                "Origin: web",
                "Postman-Token: 4f8e34c4-1192-4247-b346-7c5556772db3",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
    
    public function GeneraBodyCIP($TotalPagar, $xss_post, $reserva_id) {
        $mail = $xss_post['email'];
        $nombre = $xss_post['nombres_adl_1'];
        $apellido = $xss_post['apellidos_adl_1'];
        $country = $xss_post['geoip_pais'];
        $document_type_number = $xss_post['numdoc_adl_1'];
        $codeCountry = $xss_post['ddi_pais_cel'];
        $phone = $xss_post['num_cel'];
        $fecha_limite_utc = $xss_post['fecha_limite'];
        $fecha_limite_utc = date('c', strtotime($fecha_limite_utc));
        
        $request_cip = "{ 
                \"currency\": \"USD\",
                \"amount\": \"$TotalPagar\", 
                \"transactionCode\": \"$reserva_id\",
                \"dateExpiry\": \"$fecha_limite_utc\",
                \"adminEmail\": \"carlos.gutierrez@starperu.com\",
                \"paymentConcept\": \"Boletos\",
                \"additionalData\": \"StarPeru\",
                \"userEmail\": \"$mail\",
                \"userName\": \"$nombre\",
                \"userLastName\": \"$apellido\",
                \"userCountry\": \"$country\",
                \"userDocumentType\": \"DNI\",
                \"userDocumentNumber\": \"$document_type_number\",
                \"userCodeCountry\": \"$codeCountry\",
                \"userphone\": \"$phone\"
                
        }";
        return $request_cip;
    }

}
