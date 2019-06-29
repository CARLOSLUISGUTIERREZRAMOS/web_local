<?php

class Ciudad_model extends CI_Model {

    protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    public function GetCiudad($campos, $condicion) {

        $this->db_web->select($campos);
        $this->db_web->where($condicion);
        return $this->db_web->get('ciudad');
        
    }
    
    public function GetTuua($cod_ciudad){
        $query = $this->db_web->get_where('ciudad', array('codigo' => $cod_ciudad), 1);
        return $query->row()->tuua;
    }

}
