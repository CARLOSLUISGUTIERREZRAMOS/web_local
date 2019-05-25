<?php

/**
 * Description of Pais_model
 *
 * @author cgutierrez
 */
class Pais_model extends CI_Model {

    protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    public function GetDataPais($campos) {
        $this->db_web->select($campos);
        $this->db_web->from('pais');
        $this->db_web->where('estado', 1);
        return $this->db_web->get();
    }

    public function GetCodigoPaisPaisPorId($codigo) {
        $this->db_web->select('codigo_pais');
        $this->db_web->from('pais');
        $this->db_web->where('id',$codigo);
        $this->db_web->limit(1);
        return $this->db_web->get()->row()->codigo_pais;
    }

}
