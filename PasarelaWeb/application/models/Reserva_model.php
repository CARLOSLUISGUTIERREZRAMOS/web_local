<?php

/**
 * Description of Reserva_model
 *
 * @author cgutierrez
 */
class Reserva_model extends CI_Model {

    protected $db_web;

    public function __construct() {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    public function RegistrarReserva($data) {
        $res_insert = $this->db_web->insert('reserva', $data);
        // return $this->db_web->last_query();
        return $this->db_web->insert_id();
    }

    public function RegistrarReservaDetalle($data) {
        $this->db_web->insert('reserva_detalle', $data);
        return $this->db_web->last_query();
    }

    public function RegistrarTicket($reserva_id, $nombres_pax, $ticket) {
        $this->db_web->set('num_ticket', $ticket);
        $this->db_web->where('reserva_id', $reserva_id);
        $this->db_web->like('nombres', $nombres_pax);
        $res_regitro_ticket = $this->db_web->update('reserva_detalle');
        return $res_regitro_ticket;
    }

    function ActualizarEstadoReserva($estado, $reserva_id, $cc_code = NULL) {
        $this->db_web->set('estado', $estado);
        $this->db_web->set('cc_code', $cc_code);
        $this->db_web->where('id', $reserva_id);
        return $this->db_web->update('reserva');
    }

    function ActualizarEstadoReserva_Safetypay($estado, $reserva_id) {
        $this->db_web->set('estado', $estado);
        $this->db_web->where('id', $reserva_id);
        return $this->db_web->update('reserva');
    }

    function ActualizarEstadoReserva_PagoEfectivo($estado, $reserva_id) {
        $this->db_web->set('estado', $estado);
        $this->db_web->where('id', $reserva_id);
        return $this->db_web->update('reserva');
    }

    public function BuscarReserva($aguja, $apellidos = NULL, $condicion) {

        $this->db_web->select('id,fechahora_salida_tramo_ida,geo_pais, nombres,apellidos,fechahora_llegada_tramo_ida, '
                . 'fechahora_salida_tramo_retorno,fechahora_llegada_tramo_retorno,origen,destino,'
                . 'email,ddi_telefono,num_vuelo_retorno,num_vuelo_ida,'
                . 'pre_telefono,num_telefono,ddi_celular,pre_celular,num_celular,total,pnr,cod_compartido_vuelo_ida,'
                . 'cod_compartido_vuelo_ida,cod_compartido_vuelo_retorno,clase_ida,clase_retorno,ruc,'
                . 'tipo_documento,num_documento,total_pagar,fecha_limite,fecha_registro,estado');
        $this->db_web->from('reserva');
        switch ($condicion) {
            case 'pnr':
                $this->db_web->where('pnr', $aguja);
                $this->db_web->like('apellidos', $apellidos);
                break;
            case 'reserva_id':
                $this->db_web->where('id', $aguja);
                break;
        }
        $this->db_web->limit(1);
        $res_query = $this->db_web->get()->row();
//        return $this->db_web->last_query();
        return $res_query;
    }

    public function GetTiempoTiempoLimiteReserva($reserva_id) {
        $this->db_web->select('fecha_limite');
        $this->db_web->from('reserva');
        $this->db_web->where('id', $reserva_id);
        $this->db_web->limit(1);
        return $this->db_web->get()->row()->fecha_limite;
    }

    public function BuscarReservaPorId($reserva_id, $campos) {

        $this->db_web->select($campos);
        $this->db_web->from('reserva');
        $this->db_web->where('id', $reserva_id);
        $this->db_web->limit(1);
        $res_query = $this->db_web->get()->row();
        //        return $this->db_web->last_query();
        return $res_query;
    }

    public function ObtenerPasajerosReserva_detalle($reserva_id, $campos) {

        $this->db_web->select($campos);
        $this->db_web->from('reserva_detalle');
        $this->db_web->where('reserva_id', $reserva_id);

        return $this->db_web->get();
    }

    public function Buscar_Reserva_Todos($aguja, $apellidos) {
//
        $this->db_web->select('r.id,rd.reserva_id, r.fechahora_salida_tramo_ida, r.fechahora_llegada_tramo_ida, '
                . 'r.fechahora_salida_tramo_retorno,r.fechahora_llegada_tramo_retorno,r.origen,r.destino,'
                . 'r.email,r.ddi_telefono,r.num_vuelo_retorno,r.num_vuelo_ida,'
                . 'r.pre_telefono,r.num_telefono,r.ddi_celular,r.pre_celular,r.num_celular,r.total,r.pnr,'
                . 'r.cod_compartido_vuelo_ida,r.cod_compartido_vuelo_ida,r.cod_compartido_vuelo_retorno,r.estado');
        $this->db_web->from('reserva r');
        $this->db_web->join('reserva_detalle rd', 'rd.reserva_id=r.id');
        $this->db_web->where('rd.pnr', $aguja);
        $this->db_web->like('rd.apellidos', $apellidos);

        $res_query = $this->db_web->get()->row();
//        var_dump($alex);die;
        return $res_query;
    }

    public function GetCodigoDescuento($reserva_id){
        $this->db_web->select('descuento_id');
        $this->db_web->from('reserva');
        $this->db_web->where('id', $reserva_id);
        $this->db_web->limit(1);
        $res_query = $this->db_web->get()->row()->descuento_id;
        return $res_query;
    }

    public function ActualizarMetodoPagoTransaccion($cc_code,$reserva_id) {

        $this->db_web->set('cc_code', $cc_code);
        $this->db_web->where('id', $reserva_id);
        return $this->db_web->update('reserva');
    }
    public function VerificarExisteReserva($condicion){
        $this->db_web->select('pnr');
        $this->db_web->from('reserva');
        $this->db_web->where($condicion);
        $this->db_web->limit(11);
        return $this->db_web->get()->num_rows();
        
    }
    
    public function BuscarIdReservaPorPnr($pnr) {

        $this->db_web->select('id');
        $this->db_web->from('reserva');
        $this->db_web->where('pnr', $pnr);
        $this->db_web->limit(1);
        $res_query = $this->db_web->get()->row()->id;
        return $res_query;
    }

}
