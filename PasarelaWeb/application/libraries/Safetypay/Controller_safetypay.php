<?php

/**
 * Description of Controller_safetypay
 *
 * @author cgutierrez
 */
class Controller_safetypay {

    protected $Model_safetypay;

    function Controller_safetypay() {

        $this->CI = &get_instance();
        $this->CI->load->library('Safetypay/Model_safetypay');
        $this->Model_safetypay = new Model_safetypay();
    }

    public function CreateExpressToken($args) {

//        $this->ErrorCode = 0;
//        $this->ErrorMsg = '';
        $array = array();
        $xml = $this->Model_safetypay->Model_CreateExpressToken($args);
        $json = json_encode($xml);
        $array[0] = json_decode($json, TRUE);
        $array[1] = $xml->asXML();
        return $array;
    }

    public function GetOperation($args) {
       

//      $this->ErrorCode=0;
//      $this->ErrorMsg='';
//        $array=array();
        $xml = $this->Model_safetypay->Model_GetOperation($args);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
//        $array[1] = $xml->asXML();
        return $array;
    }

}
