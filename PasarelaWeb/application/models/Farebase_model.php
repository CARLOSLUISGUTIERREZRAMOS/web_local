<?php

class Farebase_model extends CI_Model {

    protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
        $this->load->helper('modelo');
        $this->load->helper('tiempos');
    }

    public function GetFarebases($codigo) {
        $this->db_web->select('');
    }

    public function GetTarifas($cod_origen, $cod_destino, $xss_post, $pais, $estadia_dias = NULL, $NumDiaSem = NULL, $tramo) {
        $date_filtro = ($tramo === 'IDA') ? fecha_iso_8601($xss_post['date_from']) : fecha_iso_8601($xss_post['date_to']);
        $fecha_hoy = (new DateTime())->format('Y-m-d');
        $this->db_web->select('clase.codigo AS clase,familia.nombre AS familia,tarifa_adt as tarifa');
        $this->db_web->from('farebase_has_ruta FareRuta');
        $this->db_web->join('ruta', 'FareRuta.ruta_id = ruta.id');
        $this->db_web->join('farebase', 'FareRuta.farebase_id = farebase.id');
        $this->db_web->join('clase', 'farebase.clase_codigo = clase.codigo');
//        $this->db_web->join('pais_has_clase', 'clase.codigo = pais_has_clase.clase_codigo');
//        $this->db_web->join('pais', 'pais_has_clase.pais_id = pais.id');
        $this->db_web->join('familia', 'clase.familia_codigo = familia.codigo');
        $this->db_web->where('ruta.ciudad_origen_codigo', $cod_origen);
        $this->db_web->where('ruta.ciudad_destino_codigo', $cod_destino);
        if ($xss_post['tipo_viaje'] === 'O') {
            if (($cod_origen === 'LIM' && $cod_destino === 'CUZ') || ($cod_origen === 'CUZ' && $cod_destino === 'LIM')) {
                $this->db_web->where('farebase.tipo_viaje', $xss_post['tipo_viaje']);
            }
        }

        $this->db_web->where('clase.estado', '1');
        $this->db_web->where('ruta.estado', '1');
//        $this->db_web->where('pais.codigo_pais', $pais);
        $this->db_web->where('FareRuta.estado_registro', 1);
        $this->db_web->where('FareRuta.estado_web', 1);
//        echo $estadia_dias;
        if (!is_null($estadia_dias)) {
            $nombre_dia_semana = GetDiaNombre($NumDiaSem);
//            $this->db_web->where("FareRuta.estadia_min_$nombre_dia_semana <=", $estadia_dias);
            $this->db_web->group_start();
            $where = "FareRuta.estadia_maxima >= $estadia_dias OR FareRuta.estadia_maxima = 0";
            $this->db_web->where($where);
            $this->db_web->group_end();
        }
        $this->db_web->group_start();
        $where = "'$date_filtro' BETWEEN FareRuta.inicio_vuelo AND FareRuta.final_vuelo";
        $this->db_web->where($where);
        $this->db_web->group_end();
        $this->db_web->group_start();
        $where = "'$fecha_hoy' BETWEEN FareRuta.emision_inicio AND FareRuta.emision_final";
        $this->db_web->where($where);
        $this->db_web->group_end();
        $this->db_web->order_by('tarifa', 'ASC');
        $res_query = $this->db_web->get();
//        return $this->db_web->last_query();
        return $res_query;
    }

}
