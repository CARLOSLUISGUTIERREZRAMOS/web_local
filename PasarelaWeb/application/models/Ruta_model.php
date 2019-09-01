<?php

class Ruta_model extends CI_Model {

    protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    public function GetRutas($condicion) {

        $this->db_web->select('ciudad.codigo,ciudad.nombre');
        $this->db_web->from('ruta');
        $this->db_web->join('ciudad', 'ciudad.codigo = ruta.ciudad_destino_codigo');
        $this->db_web->where($condicion);
        $res_query = $this->db_web->get();
//        return $this->db_web->last_query();
        return $res_query;
    }

    public function VerificarRutaExonerada($cod_origen, $cod_destino) {
        $this->db_web->select('exonerado');
        $this->db_web->from('ruta');
        $this->db_web->where('ciudad_origen_codigo', $cod_origen);
        $this->db_web->where('ciudad_destino_codigo', $cod_destino);
        
        $res_query = $this->db_web->get()->row()->exonerado;
        return (bool)$res_query;
        
    }

    public function GetIdRuta($codOrigen,$codDestino){

        $this->db_web->select('id');
        $this->db_web->from('ruta');
        $this->db_web->where('ciudad_origen_codigo', $codOrigen);
        $this->db_web->where('ciudad_destino_codigo', $codDestino);
        
        return $this->db_web->get()->row()->id;

    }

}
