<?php

/**
 * Description of AppVisa
 *
 * @author cgutierrez
 */
class ApiVisaNet extends CI_Controller {

    private $visa;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('kiu');
        $this->load->helper('visa');
        $this->load->helper('tiempos');
        $this->load->helper('logsystemweb');
        $this->load->library('form_validation');
        $this->load->library('Visa/Connection_visa');
        $this->load->library('kiu/Controller_kiu');
        $this->load->model('Visa_model');
        $this->load->model('Reserva_model');
        $this->template->add_js('js/web/ticket.js');
    }

    public function Index() {

        $xss_post_redirect = $this->input->post(NULL, TRUE);
        if (isset($xss_post_redirect['transactionToken']) && isset($this->session->id_reserva)) {
            $this->visa = new Connection_visa();
            $tokenFormulario = $xss_post_redirect['transactionToken'];
            $sess_token_seguridad_visa = $this->session->token_seguridad_visa;
            $sess_id_reserva = $this->session->id_reserva;
            $campos = 'id,num_documento,tipo_documento,total_pagar,id,pnr,ruc,fecha_registro,nombres,apellidos,email,origen,destino';
            $data_reserva = $this->Reserva_model->BuscarReservaPorId($sess_id_reserva, $campos);
            $body = $this->visa->GenerarBody_AutorizacionTransaccion($data_reserva->num_documento, $data_reserva->tipo_documento, $data_reserva->total_pagar, $data_reserva->id, $tokenFormulario);
            $res_ws_visa = $this->visa->SolicitarAutorizacionTransaccion($sess_token_seguridad_visa, $body);
            
            dispara_log($this->session->id_reserva,'VI','AUTORIZAR_TRANSACCION', print_r($res_ws_visa,true),'RS');
            if (isset($res_ws_visa)) {
                $res_array_data = ArmarDataParaInsertar($res_ws_visa, $sess_id_reserva);
                $res = $this->Visa_model->GuardarTransaccion($res_array_data);
                $DataJsonVisa = json_decode($res_ws_visa, false);
//            echo "<pre>";
//            var_dump($DataJsonVisa);
//            echo "</pre>";
//            die;
                if (isset($DataJsonVisa->errorCode) && $DataJsonVisa->errorCode === 400) {

                    $data_vista_error['cod_error_visa'] = $DataJsonVisa->errorCode;
                    $data_vista_error['dataVisa'] = $DataJsonVisa;
                    $data_vista_error['dataVisa_reserva'] = $data_reserva;

                    $this->load->view('templates/v_error_proceso_pago', $data_vista_error);
                } else {
                    //TODO OK
                    $TiempoValidoReProcesarReserva = RetornaHorasDiferencias($this->Reserva_model->GetTiempoTiempoLimiteReserva($sess_id_reserva));
                    if ($TiempoValidoReProcesarReserva) {
                        $kiu = new Controller_kiu();
                        $PaymentType = 5;
                        switch ($DataJsonVisa->dataMap->BRAND) {
                            case 'visa':
                                $miscellaneous = 'VI';
                                break;
                            case 'amex,':
                                $miscellaneous = 'AX';
                                break;
                            case 'mastercard,':
                                $miscellaneous = 'MC';
                                break;
                            case 'dinersclub':
                                $miscellaneous = 'DC';
                                break;
                            default : header("Location: " . base_url());
                        }
                        $trama_enviar_metodo_demandKiu = ArmarTramaTipoCredito_DemandTicket($miscellaneous, $PaymentType, $sess_id_reserva, $data_reserva->pnr, $data_reserva->ruc, $DataJsonVisa->order->authorizationCode, $DataJsonVisa->dataMap->CARD);

                        $ResDemandTicket['dataVisa'] = $DataJsonVisa;
                        $ResDemandTicket['data'] = $kiu->AirDemandTicketRQ($trama_enviar_metodo_demandKiu, $err);
                        $ResDemandTicket['data_reserva'] = $data_reserva;
//                var_dump($ResDemandTicket['data']);die;

                        foreach ($ResDemandTicket['data']->TicketItemInfo as $row) {
                            $ticket_number = $row->attributes()->TicketNumber;
                            $email_upper = strtoupper($data_reserva->email);
                            $trama = array('IdTicket' => "$ticket_number", 'Email' => "$email_upper");
                            $kiu->TravelItineraryReadRQ($trama, $err);
                            $nombres_pax = $row->PassengerName->GivenName;
                            $res_update_tbl_reserva_detalle = $this->Reserva_model->RegistrarTicket($sess_id_reserva, $nombres_pax, $ticket_number);
                            if ($res_update_tbl_reserva_detalle) {
                                $this->Reserva_model->ActualizarEstadoReserva(1, $sess_id_reserva, $miscellaneous);
                            }
                        }

//                        $this->template->add_js_analitics('js/web/exito.js');
                               $this->load->view('vistas_exito/v_exito_visa_analitics', $ResDemandTicket);
//                        $this->template->load('vistas_exito/v_exito_visa', $ResDemandTicket);
                        $this->load->view('politicas_negocio/terminos_condiciones');
                        $this->load->view('politicas_negocio/politicas_devolucion');
                        $this->load->view('templates/v_modal_show_ticket');
                        $this->session->unset_userdata('id_reserva');
                    } else {
                        dispara_log($this->session->id_reserva,'VI','Autorizacion VISA','Se supera el tiempo limite ','RS DB STARPERU');
                        header("Location: " . base_url());
                    }
                }
            }else{
                dispara_log($this->session->id_reserva,'VI','Autorizacion VISA','Error al ejecutar el metodo **SolicitarAutorizacionTransaccion**','RS');
                header("Location: " . base_url());
            }
        } else {
            $id_reserva = (isset($this->session->id_reserva)) ? $this->session->id_reserva : 'NO SESSION ID RESERVA';
            dispara_log($id_reserva,'VI','transactionToken','No se recibe el post','RS');
            header("Location: " . base_url());
        }
    }

}
