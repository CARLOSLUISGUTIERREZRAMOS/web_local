<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiSafetypay
 *
 * @author aespinoza
 */
class ApiSafetypay extends CI_Controller {

    private $safetypay_model;
    private $reserva_model;

    public function __construct() {
        parent::__construct();
        $this->load->library('kiu/Controller_kiu');
        $this->load->model('Reserva_model');
        $this->load->model('SafetyPay_model');

        $this->load->helper('kiu');
        $this->load->library('Safetypay/Connection_safetypay');

        $this->load->helper('tiempos');
        $this->load->library('session');
        $this->load->helper('safetypay');
    }

    

    public function Index() {

        $safetypay_conection = new Connection_safetypay();
        if (strip_tags($_POST['ApiKey']) != '') {

            date_default_timezone_set('America/Lima');
            $this->safetypay_model = new SafetyPay_model();
            $this->reserva_model = new Reserva_model();

            $ip = $_SERVER["REMOTE_ADDR"];

            $ApiKey = $_POST['ApiKey'];
            $Status = $_POST['Status'];
            $estado_total = Retonar_Estado($Status);
            $datos = explode("-", $_POST['MerchantSalesID']);
            $id_reserva = $datos[1];

            $ResponseDateTime = $_POST['RequestDateTime'];
            $ErrorNumber = 0;
            $MerchantSalesID = $_POST['MerchantSalesID'];
            $ReferenceNo = $_POST['ReferenceNo'];
            $CreationDateTime = $_POST['CreationDateTime'];
            $Amount = $_POST['Amount'];
            $CurrencyID = $_POST['CurrencyID'];
            $PaymentReferenceNo = $_POST['PaymentReferenceNo'];
            $OrderNo = $_POST['MerchantSalesID'];

            $this->safetypay_model->actualizar_respuesta_safetypay($MerchantSalesID, $Status, $estado_total);


//            $mensaje = Campos_post_Safetypay($MerchantSalesID, $ApiKey, $ResponseDateTime, $ReferenceNo, $CreationDateTime, $Amount, $CurrencyID, $PaymentReferenceNo, $Status);
//            $respuesta = Campos_respuesta_Safetypay($MerchantSalesID, $ResponseDateTime, $ReferenceNo, $CreationDateTime, $Amount, $CurrencyID, $PaymentReferenceNo, $Status);
//
//
//            $metodo1 = "Campos_post_Safetypay";
//            $metodo2 = "Campos_respuesta_Safetypay";
//            dispara_log($id_reserva, 'SP', $metodo1, print_r($mensaje, true), 'RQ');
//            dispara_log($id_reserva, 'SP', $metodo2, print_r($respuesta, true), 'RS');

            if ($Status === "102") {

                $kiu = new Controller_kiu();
                $campos = 'id,fecha_registro,num_vuelo_ida,num_vuelo_retorno,fechahora_salida_tramo_ida,'
                        . 'fechahora_llegada_tramo_retorno,clase_ida,clase_retorno,tipo_viaje,pnr,total_pagar,origen,destino,ruc,email';
                $data_reserva = $this->Reserva_model->BuscarReservaPorId($id_reserva, $campos);
                $miscellaneous = "SP";
                $PaymentType = 37;
                $ruc = ($data_reserva->ruc === 'NULL') ? '' : $data_reserva->ruc;
                $trama_demandTicket = ArmarTramaTipoMiscelaneo_DemandTicket($miscellaneous, $PaymentType, $id_reserva, $data_reserva->pnr, $ruc);
                $rs_wskiu_demandTkt = $kiu->AirDemandTicketRQ($trama_demandTicket, $err);
                $this->reserva_model->ActualizarEstadoReserva_Safetypay("1", $id_reserva);
                foreach ($rs_wskiu_demandTkt->TicketItemInfo as $row) {
                    $ticket_number = $row->attributes()->TicketNumber;
                    $email_upper = strtoupper($data_reserva->email);
                    $trama = array('IdTicket' => "$ticket_number", 'Email' => "$email_upper");
                    $kiu->TravelItineraryReadRQ($trama, $err);
                    $nombres_pax = $row->PassengerName->GivenName;
                    $this->Reserva_model->RegistrarTicket($id_reserva, $nombres_pax, $ticket_number);
                    $data['data_reserva'] = $data_reserva;
                    $this->load->view('vistas_exito/v_viajala',$data);
                }
            } else {
                $this->reserva_model->ActualizarEstadoReserva_Safetypay("0", $id_reserva);
            }

            $SignatureKey = $safetypay_conection->GetSignatureKey();
            $data = $ResponseDateTime . $MerchantSalesID . $ReferenceNo . $CreationDateTime . $Amount . $CurrencyID . $PaymentReferenceNo . $Status . $OrderNo . $SignatureKey;
            $SignatureHash = hash_signature($data);

            echo $ErrorNumber . ',';
            echo $ResponseDateTime . ',';
            echo $MerchantSalesID . ',';
            echo $ReferenceNo . ',';
            echo $CreationDateTime . ',';
            echo $Amount . ',';
            echo $CurrencyID . ',';
            echo $PaymentReferenceNo . ',';
            echo $Status . ',';
            echo $OrderNo . ',';
            echo $SignatureHash;
        } else {
            header('Location:http://www.starperu.com/');
        }
    }

}
