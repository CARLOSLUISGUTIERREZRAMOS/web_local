<?php

/**
 * Description of Conection_paypal
 *
 * @author cgutierrez
 */
class Conection_paypal {

    protected $PayPalApiUsername;
    protected $PayPalApiPassword;
    protected $PayPalApiSignature;
    protected $PayPalReturnURL;
    protected $PayPalCancelURL;
    protected $PayPalAmbiente;

    public function __construct() {

//======================== PROD =====================================
//                $this->PayPalApiUsername = 'star.empresa_api2.starperu.com';
//                $this->PayPalApiPassword = '9RDTX5RLKWFW2NMB';
//                $this->PayPalApiSignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AH2fLsliCV-r9CDi1YfxeNpK0ebt';
//                $this->PayPalAmbiente = '';
//======================== SANDBOX =====================================
        $this->PayPalApiUsername  = 'star.empresa-facilitator_api1.starperu.com'; //PayPal API Username
        $this->PayPalApiPassword  = 'V7LJFNSLG22FRAR8'; //Paypal API password
        $this->PayPalApiSignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AMgtCeIc.EurhNZTBhjRcN8d0r5x'; //Paypal API Signature
        $this->PayPalAmbiente = '.sandbox';

        $this->setPayPalReturnURL();
        $this->setPayPalCancelURL();
    }

    public function PPHttpPost($methodName_, $nvpStr_) {
        $API_UserName = urlencode($this->PayPalApiUsername);
        $API_Password = urlencode($this->PayPalApiPassword);
        $API_Signature = urlencode($this->PayPalApiSignature);

        $API_Endpoint = "https://api-3t" . $this->PayPalAmbiente. ".paypal.com/nvp";
        $version = urlencode('109.0');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }
        return $httpParsedResponseAr;
    }

    private function setPayPalReturnURL() {
        $url = $this->GenerarUrl();
//        $this->PayPalReturnURL = $url . '/ZonaPagos/ApiPayPal';
        $this->PayPalReturnURL = 'https://www.starperu.com/PasarelaWeb/ZonaPagos/ApiPayPal';
    }

    private function setPayPalCancelURL() {
        $url = $this->GenerarUrl();
        $this->PayPalCancelURL = 'https://www.starperu.com/PasarelaWeb/html/metodos_pagos/redireccion_cancel.html';
    }
    
    function getPayPalReturnURL() {
        return $this->PayPalReturnURL;
    }

    function getPayPalCancelURL() {
        return $this->PayPalCancelURL;
    }

    private function GenerarUrl() {
//        $url = $this->GenerarUrl();
        return dirname('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
//        return "http://sslzone.starperu.com";
    }
    function getPayPalAmbiente() {
        return $this->PayPalAmbiente;
    }



}
