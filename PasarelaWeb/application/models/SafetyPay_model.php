<?php

/**
 * Description of SafetyPay_Model
 *
 * @author cgutierrez
 */
class SafetyPay_model extends CI_Model {

    protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    function insertarprueba($id_reserva, $data) {
        $this->db_web->set('codigo_pago', $data);
        $this->db_web->where('reserva_id', $id_reserva);
        $this->db_web->update('safetypay');
    }

    function actualizar_respuesta_safetypay($MerchantSalesID, $Status,$descripcion) {
        $datos = explode("-", $MerchantSalesID);
        $id_reserva = $datos[1];
        $FechaConfirmacion = date("Y-m-d H:i:s");

        $data = array(
            'codigo_estado' => $Status,
            'descripcion_estado' => $descripcion,
            'fecha_confirmacion' => $FechaConfirmacion,
        );

        $this->db_web->where('reserva_id', $id_reserva);
        $this->db_web->update('safetypay', $data);
    }

    function insertar_campos_reserva_safetypay($reserva_id) {
        $Fechaoperacion = date("Y-m-d H:i:s");

        $data_2 = array(
            'reserva_id' => $reserva_id,
            'fecha_operacion' => $Fechaoperacion,
        );

        $this->db_web->insert('safetypay', $data_2);
        return $this->db_web->insert_id();
    }

}
