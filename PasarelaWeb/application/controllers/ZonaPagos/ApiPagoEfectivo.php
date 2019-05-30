<?php

/**
 * Description of ApiPagoEfectivo
 *
 * @author CGUTIERREZ
 */
class ApiPagoEfectivo extends CI_Controller {

    private $pagoefectivo_model;
    private $kiu;

    public function __construct() {
        parent::__construct();
        $this->load->model('PagoEfectivo_model');
        $this->load->model('Reserva_model');
        $this->load->helper('kiu');
        $this->load->helper('logsystemweb');
        $this->load->library('kiu/Controller_kiu');
        $this->kiu = new Controller_kiu();
    }

    function index() {


        $boletos = $this->Reserva_model->ObtenerBoletosReserva(1781248);

        foreach ($boletos->Result() as $boleto) {
            echo $boleto;
        }

        die;
        if (isset($_POST)) {



            $archivo = $this->getRutaArchivo();
            $contenido_archivo = $this->ObtenerContenidoDeArchivo($archivo);
            $paises = json_decode($contenido_archivo, false);


            $this->reserva_model = new Reserva_model();
            $this->pagoefectivo_model = new PagoEfectivo_model();
            $cip = $_POST['data']['cip'];
            $estado_cip = $_POST['eventType'];
            $id_reserva = $this->pagoefectivo_model->consulta_reservaid($cip);
            dispara_log($id_reserva, "PE", "NOTIFICACION_POST_PAGOEFECTIVO", print_r($_POST, true), "POST");
            switch ($estado_cip) {

                case "cip.paid":

                    $campos = 'id,fecha_registro,num_vuelo_ida,num_vuelo_retorno,fechahora_salida_tramo_ida,'
                            . 'fechahora_llegada_tramo_retorno,clase_ida,clase_retorno,tipo_viaje,pnr,total_pagar,origen,destino,ruc';
                    $data_reserva = $this->Reserva_model->BuscarReservaPorId($id_reserva, $campos);
                    $miscellaneous = "PE";
                    $PaymentType = 37;
                    $ruc = ($data_reserva->ruc === 'NULL') ? '' : $data_reserva->ruc;
                    $trama_demandTicket = ArmarTramaTipoMiscelaneo_DemandTicket($miscellaneous, $PaymentType, $id_reserva, $data_reserva->pnr, $ruc);
                    $rs_wskiu_demandTkt = $this->kiu->AirDemandTicketRQ($trama_demandTicket, $err);

                    foreach ($rs_wskiu_demandTkt->TicketItemInfo as $row) {
                        $ticket_number = $row->attributes()->TicketNumber;
                        $nombres_pax = $row->PassengerName->GivenName;
                        $this->Reserva_model->RegistrarTicket($id_reserva, $nombres_pax, $ticket_number);
                    }
                    $this->reserva_model->ActualizarEstadoReserva_PagoEfectivo("1", $id_reserva);
                    $this->pagoefectivo_model->actualizar_campos_post($cip, $estado_cip);
                    break;
                case "cip.expired":
                    $this->reserva_model->ActualizarEstadoReserva_PagoEfectivo("0", $id_reserva);
                    $this->pagoefectivo_model->actualizar_campos_post($cip, $estado_cip);
                    break;
                case "cip.refunded":
                    $num_ticket = $this->Reserva_model->ObtenerPasajerosReserva_detalle($id_reserva, 'num_ticket');

                    $tickets = array();
                    $boletos = $this->Reserva_model->obtener_boletos_reserva($id_reserva);

                    foreach ($boletos as $boleto) {
                        array_push($tickets, $boleto['num_ticket']);
                    }
                    $cant_tickets = count($tickets);
                    $data_reserva = $this->Reserva_model->BuscarReservaPorId($id_reserva, 'pnr');
                    for ($i = 0; $i < $cant_tickets; $i++) {
                        $args = array(
                            'IdReserva' => $data_reserva->pnr,
                            'IdTicket' => $tickets[$i]
                        );
                        $res_cancel_kiu = $this->kiu->AirCancelRQ($args, $err);
                        dispara_log_kiu($id_reserva, 'AirCancelRQ', html_entity_decode($res_cancel_kiu[1]), html_entity_decode($res_cancel_kiu[2]));
                    }

                    if (is_null($num_ticket)) {
                        $this->reserva_model->ActualizarEstadoReserva_PagoEfectivo("0", $id_reserva);
                    } else {
                        $this->reserva_model->ActualizarEstadoReserva_PagoEfectivo("0", $id_reserva);
                        $this->pagoefectivo_model->eliminar_ticket_reserva_detalle($id_reserva);
                    }

                    $this->pagoefectivo_model->actualizar_campos_post($cip, $estado_cip);
                    break;
            }
        }
    }

}
