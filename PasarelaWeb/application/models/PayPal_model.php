<?php

/**
 * Description of PayPal_model
 *
 * @author cgutierrez
 */
class PayPal_model extends CI_Model {

    protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    function RegistrarTransaccion($data) {
        $this->db_web->insert('paypal', $data);
        return $this->db_web->insert_id();
    }

    function RegistrarTransaccionMetodos() {
        $res = $this->db_web->insert('paypal', $data);
        return $res;
    }

}
