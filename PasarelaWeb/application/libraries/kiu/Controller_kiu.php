<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controller_kiu {

    protected $Model_kiu; 

    function Controller_kiu() {
        $this->CI = &get_instance();
        $this->CI->load->library('kiu/Model_kiu');
        $this->Model_kiu = new Model_kiu();
        $this->TimeStamp = date("c");
    }

    public function AirAvailRQ($args, &$err) {
        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $xml = $this->Model_kiu->Model_AirAvailRQ($args);
        $json = json_encode($xml[0]);
        $array = json_decode($json, TRUE);
        $err = array('ErrorCode' => $this->ErrorCode, 'ErrorMsg' => $this->ErrorMsg);
        $salida = array();
        $salida[] = $array;
        $salida[] = $xml[1];
        $salida[] = $xml[2];
        $salida[] = $xml[3];
        return $salida;
    }

    public function AirBookRQ($args, &$err) {
        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $xml = $this->Model_kiu->Model_AirBookRQ($args);
//        return $xml;
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        $err = array('ErrorCode' => $this->ErrorCode, 'ErrorMsg' => $this->ErrorMsg);
        $salida = array();
        $salida[] = $array;
        $salida[] = $xml[1];
        $salida[] = $xml[2];
        $salida[] = $xml[3];
        return $salida;
    }

    public function AirPriceRQ($args, &$err) {

        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $xml = $this->Model_kiu->Model_AirPriceRQ($args);
        $json = json_encode($xml[0]);
        $array = json_decode($json, TRUE);
        $err = array('ErrorCode' => $this->ErrorCode, 'ErrorMsg' => $this->ErrorMsg);
        $salida = array();
        $salida[] = $array;
        $salida[] = $xml[1];
        $salida[] = $xml[2];
        $salida[] = $xml[3];
        return $salida;
    }

    public function AirDemandTicketRQ($args, &$err) {
        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $xml = $this->Model_kiu->Model_AirDemandTicketRQ($args);
        $json = json_encode($xml[0]);
        $array = json_decode($json, TRUE);
        $err = array('ErrorCode' => $this->ErrorCode, 'ErrorMsg' => $this->ErrorMsg);
        $salida = array();
        $salida[] = $array;
        $salida[] = $xml[1];
        $salida[] = $xml[2]; //RS XML
        $salida[] = $xml[3];
        return $salida[3];
    }

    public function TravelItineraryReadRQ($args, &$err) {
        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $xml = $this->Model_kiu->Model_TravelItineraryReadRQ($args);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        $err = array('ErrorCode' => $this->ErrorCode, 'ErrorMsg' => $this->ErrorMsg);
        return $array;
    }

    public function AirCancelRQ($args, &$err) {
        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $xml = $this->Model_kiu->Model_AirCancelRQ($args);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        $err = array("ErrorCode" => $this->ErrorCode, "ErrorMsg" => $this->ErrorMsg);
        $salida = array();
        $salida[] = $array;//RQ->
        $salida[] = $xml[1];//RQ->XML
        $salida[] = $xml[2];//RS->XML 
        $salida[] = $xml[3];//RS->[]
        return $salida;
    }

    public function AirFareDisplayRQ($args, &$err) {
        $this->ErrorCode = 0;
        $this->ErrorMsg = '';
        $respuesta_model = $this->Model_kiu->Model_AirFareDisplayRQ($args);
        $json = json_encode($respuesta_model);
        $array = json_decode($json, TRUE);
        $err = array("ErrorCode" => $this->ErrorCode, "ErrorMsg" => $this->ErrorMsg);
        $salida[] = $array;
        $salida[] = $respuesta_model[1];
        $salida[] = $respuesta_model[2];
        return $salida;
    }

}

?>