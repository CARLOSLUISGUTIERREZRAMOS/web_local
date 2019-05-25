<?php
/**
 * Description of Visa_model
 *
 * @author cgutierrez
 */
class Visa_model extends CI_Model {
    
    protected $db_web;
    
    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }
    
    public function GuardarTransaccion($data){
        return $this->db_web->insert('visa', $data);
    }
    
}
