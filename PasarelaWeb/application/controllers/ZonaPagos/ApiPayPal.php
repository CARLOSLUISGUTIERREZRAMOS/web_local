<?php

/**
 * Description of RecibiendoDataWebServicesPayPal
 * Controlador encargado de recibir los datos que envia PayPal de sus servicios.
 *
 * @author cgutierrez
 */
class ApiPayPal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('PayPal/Conection_paypal');
        $this->load->library('kiu/Controller_kiu');
        $this->load->model('Reserva_model');
        $this->load->model('PayPal_model');
        $this->load->helper('kiu');
        $this->load->helper('tiempos');
        $this->load->helper('paypal_helper');
        $this->template->add_js('js/web/ticket.js');
        $this->load->helper('logsystemweb');
    }

    public function Index() {
        if (isset($this->session->reserva_id)) {
            $PayPal = new Conection_paypal();
            $kiu = new Controller_kiu();
            $nvpStr_ = '&TOKEN=' . urlencode($_GET["token"]);
            dispara_log($this->session->reserva_id, 'PP', 'GetExpressCheckoutDetails', $nvpStr_, 'RQ');
            $res_pp_get = $PayPal->PPHttpPost('GetExpressCheckoutDetails', $nvpStr_);
            dispara_log($this->session->reserva_id, 'PP', 'GetExpressCheckoutDetails', print_r($res_pp_get, true), 'RS');
            if ($res_pp_get['ACK'] === 'Success' || strtoupper($res_pp_get['ACK']) === 'SUCCESSWITHWARNING') {
                $token = $_GET['token'];
                $payer_id = $_GET['PayerID'];
                $reserva_id = $this->session->reserva_id;
                $campos = 'nombres,apellidos';
                $pasajeros = $this->Reserva_model->ObtenerPasajerosReserva_detalle($reserva_id, $campos);
                $campos = 'id,fecha_registro,num_vuelo_ida,num_vuelo_retorno,fechahora_salida_tramo_ida,'
                        . 'fechahora_llegada_tramo_retorno,clase_ida,clase_retorno,tipo_viaje,pnr,total_pagar,origen,destino,ruc,email';
                $data_reserva = $this->Reserva_model->BuscarReservaPorId($reserva_id, $campos);
                $data_vista['data_reserva'] = $data_reserva;
                $metodo_do_pp = padata_DoExpressCheckoutPayment($token, $payer_id, $data_reserva->pnr, $reserva_id, $data_reserva->total_pagar, $pasajeros, $data_reserva->fechahora_salida_tramo_ida, $data_reserva->fechahora_llegada_tramo_retorno, $data_reserva->origen, $data_reserva->destino, $data_reserva->num_vuelo_ida, $data_reserva->num_vuelo_retorno, $data_reserva->clase_ida, $data_reserva->clase_retorno, $data_reserva->tipo_viaje);
                dispara_log($this->session->reserva_id, 'PP', 'DoExpressCheckoutPayment', $metodo_do_pp, 'RQ');
                $httpParsedResponseAr = $PayPal->PPHttpPost('DoExpressCheckoutPayment', $metodo_do_pp);
                dispara_log($this->session->reserva_id, 'PP', 'DoExpressCheckoutPayment', print_r($httpParsedResponseAr, true), 'RS');
                $JsonRsPayPal = json_decode(json_encode($httpParsedResponseAr));
                if ($JsonRsPayPal->ACK != 'Success' && $JsonRsPayPal->ACK != 'SuccessWithWarning') {
//                    var_dump($JsonRsPayPal);
                    $data_vista['error_code'] = $JsonRsPayPal->L_ERRORCODE0;
                    $data_vista['msg_pp'] = $JsonRsPayPal->L_SHORTMESSAGE0;
                    $data_pp_insert = array('reserva_id' => $reserva_id, 'resultado_metodo' => $JsonRsPayPal->ACK, 'cod_error' => $JsonRsPayPal->L_ERRORCODE0, 'mensaje' => urldecode($JsonRsPayPal->L_SHORTMESSAGE0), 'monto_transaccion' => $data_reserva->total_pagar);
                    $this->PayPal_model->RegistrarTransaccion($data_pp_insert);
                    $this->load->view('templates/v_error_proceso_pago_pp', $data_vista);
                } else {
                    if ($JsonRsPayPal->PAYMENTINFO_0_PAYMENTSTATUS === 'Completed' && ($JsonRsPayPal->PAYMENTINFO_0_ACK === 'Success' || $JsonRsPayPal->PAYMENTINFO_0_ACK === 'SuccessWithWarning') && $JsonRsPayPal->PAYMENTINFO_0_ERRORCODE === '0') {
                        if (isset($JsonRsPayPal->L_ERRORCODE0) || isset($JsonRsPayPal->L_SHORTMESSAGE0)) {
                            $data_pp_insert = array('reserva_id' => $reserva_id, 'resultado_metodo' => $JsonRsPayPal->ACK, 'cod_error' => $JsonRsPayPal->L_ERRORCODE0, 'mensaje' => urldecode($JsonRsPayPal->L_SHORTMESSAGE0), 'monto_transaccion' => urldecode($JsonRsPayPal->PAYMENTINFO_0_AMT));
                            $this->PayPal_model->RegistrarTransaccion($data_pp_insert);
                        } else {
                            $data_pp_insert = array('reserva_id' => $reserva_id, 'resultado_metodo' => $JsonRsPayPal->ACK, 'monto_transaccion' => urldecode($JsonRsPayPal->PAYMENTINFO_0_AMT));
                            $this->PayPal_model->RegistrarTransaccion($data_pp_insert);
                        }
                    }

                    $ruc = ($data_reserva->ruc === 'NULL') ? '' : $data_reserva->ruc;
                    $PaymentType = 37;
                    $miscellaneous = "PP";
                    $trama_demandTicket = ArmarTramaTipoMiscelaneo_DemandTicket($miscellaneous, $PaymentType, $reserva_id, $data_reserva->pnr, $ruc);
                    $rs_wskiu_demandTkt = $kiu->AirDemandTicketRQ($trama_demandTicket, $err);
                    foreach ($rs_wskiu_demandTkt->TicketItemInfo as $row) {
                        $ticket_number = $row->attributes()->TicketNumber;
                        $email_upper = strtoupper($data_reserva->email);
                        $trama = array('IdTicket' => "$ticket_number", 'Email' => "$email_upper");
                        $kiu->TravelItineraryReadRQ($trama, $err);

                        $nombres_pax = $row->PassengerName->GivenName;
                        $res_update_tbl_reserva_detalle = $this->Reserva_model->RegistrarTicket($reserva_id, $nombres_pax, $ticket_number);

                        if ($res_update_tbl_reserva_detalle) {
                            $this->Reserva_model->ActualizarEstadoReserva(1, $reserva_id, $miscellaneous);
                        }
                    }
                    $this->session->unset_userdata('reserva_id');
                    $data_vista['data'] = $rs_wskiu_demandTkt;
                    $this->load->view('vistas_exito/v_exito_visa_analitics', $data_vista);
//                    $this->template->load('vistas_exito/v_exito_paypal', $data_vista);
                    $this->load->view('politicas_negocio/politicas_devolucion');
                    $this->load->view('politicas_negocio/terminos_condiciones');
                    $this->load->view('templates/v_modal_show_ticket');
                }
            }
        } else {
            header("Location: " . base_url());
        }
    }

}
