<?php

/**
 * Description of Model_safetypay
 *
 * @author cgutierrez
 */
class Model_safetypay {

    protected $connection;

    function Model_safetypay() {
        $this->CI = &get_instance();
        $this->CI->load->library('Safetypay/Connection_safetypay');
        $this->connection = new Connection_safetypay();
    }

    public function Model_CreateExpressToken($args) {
        $this->connection->Connection($this->connection->TokenURLExpressSafetyPay);
        $response = $this->connection->SendMessage($args);
        $this->connection->CloseConnection();
        return simplexml_load_string($response);
    }

    public function Model_GetOperation($args) {
        $this->connection->Connection($this->connection->WSConsultaSafetyPay);
         $response = $this->connection->SendMessage($args);
         $this->connection->CloseConnection();
        return simplexml_load_string($response);
    }

}
