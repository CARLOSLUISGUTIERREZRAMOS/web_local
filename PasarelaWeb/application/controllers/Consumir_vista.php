<?php
class Consumir_vista extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('kiu/Controller_kiu');
    }
    
    function Index(){
    
                $this->load->view('templates/v_error_proceso_pago');
        
                 
        
        
    }
}
