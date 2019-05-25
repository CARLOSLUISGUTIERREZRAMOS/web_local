<?php

class PagoEfectivo_model extends CI_Model {

    protected $db_web;
    protected $Campos_Post;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    public function GuardarTransaccion($data) {
        
        return $this->db_web->insert('pagoefectivo', $data);
    }

//    public function actualizar_reserva($cip, $reserva_id) {
//
//        $FechaConfirmacion = date("Y-m-d H:i:s");
//
//        $this->db_web->set('fecha_operacion', $FechaConfirmacion);
//        $this->db_web->set('cip', $cip);
//        $this->db_web->where('reserva_id', $reserva_id);
//        $this->db_web->update('pagoefectivo');
//    }

    public function actualizar_campos_reserva_pagoefectivo($actualizar_data, $reserva_id) {

        $this->db_web->where('reserva_id', $reserva_id);
        $this->db_web->update('pagoefectivo', $actualizar_data);
    }

    public function consulta_reservaid($cip) {

        $this->db_web->select('reserva_id');
        $this->db_web->from('pagoefectivo');
        $this->db_web->where('cip', $cip);
        $this->db_web->limit(1);
     $res_query = $this->db_web->get()->row()->reserva_id;
         
        return $res_query;
    }

    public function actualizar_campos_post($cip, $eventType) {
        $FechaConfirmacion = date("Y-m-d H:i:s");
        $data = array(
            'estado_cip' => $eventType,
            'fecha_confirmacion' => $FechaConfirmacion
        );

        $this->db_web->where('cip', $cip);
        $this->db_web->update('pagoefectivo', $data);
    }

    public function eliminar_ticket_reserva_detalle($id_reserva) {

        $this->db_web->set('num_ticket', NULL);
        $this->db_web->where('reserva_id', $id_reserva);
        $this->db_web->update('reserva_detalle');
    }

}
