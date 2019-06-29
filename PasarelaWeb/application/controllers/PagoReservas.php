<?php

/**
 * Description of Pago_reservas
 *
 * @author cgutierrez
 */
class PagoReservas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('kiu/Controller_kiu');
        $this->load->model('Reserva_model');
        $this->load->model('Pais_model');
        $this->load->helper('tiempos');

        $this->template->add_js('js/web/pago_reservas.js');
        $this->template->add_js('js/web/pasodos.js');
        //        pago_reservas
    }

    public function Sugerir()
    {

        $codigo_reserva = $this->session->pnr;
        $apellido = $this->session->apellidos;

        $data['res_model_vuelo'] = $this->Reserva_model->BuscarReserva($codigo_reserva, $apellido, 'pnr');
        if ((int)$data['res_model_vuelo']->estado === 0) {
            $TiempoValidoReProcesarReserva = RetornaHorasDiferencias($data['res_model_vuelo']->fecha_limite);

            if ($TiempoValidoReProcesarReserva) {
                if (!is_null($data['res_model_vuelo'])) {
                    $reserva_id = $data['res_model_vuelo']->id;
                    $data['paises'] = $this->Pais_model->GetDataPais('id,nombre_pais');
                    $data['cod_ddi_paises'] = $this->Pais_model->GetDataPais('codigo_pais,ddi');
                    $campos = 'nombres,apellidos,tipo_documento,num_documento,tipo_pasajero';
                    $data['res_model_pasajero'] = $this->Reserva_model->ObtenerPasajerosReserva_detalle($reserva_id, $campos);
                    $this->template->load('v_pago_reservas', $data);
                    $this->load->view('politicas_negocio/terminos_condiciones');
                    $this->load->view('politicas_negocio/termino_condiciones_transporte');
                } else {
                    header("Location: " . base_url());
                }
            } else {
                header("Location: " . base_url());
            }
        } else {
            header("Location: " . base_url() . 'html/web/reserva_pagada.html');
        }
    }

    private function ValidarFormulario()
    {
        $this->form_validation->set_rules('codigo_reserva', 'codigo_reserva', 'trim|required|min_length[6]|max_length[6]');
        $this->form_validation->set_rules('apellido', 'apellido', 'required', 'trim|required|max_length[70]');
    }

    public function Index()
    {
        $this->ValidarFormulario();
        if ($this->form_validation->run() == FALSE) {
            header("Location: " . base_url());
        } else {
            $xss_post = $this->input->post(NULL, TRUE);
            $codigo_reserva = $xss_post['codigo_reserva'];
            $kiu = new Controller_kiu();
            $args = array('CodReserva' => $codigo_reserva);
            $Itinerary = $kiu->TravelItineraryReadRQ($args, $err)[3]; //CAPTURADO COMO OBJ
            $Itinerary_xml = $kiu->TravelItineraryReadRQ($args, $err)[2]; //CAPTURADO COMO XML
            
            echo "<pre>";
            echo $Itinerary_xml;
            echo "<pre>";
            
            
            $pnr = $Itinerary->TravelItinerary->ItineraryRef->attributes()->ID;
            $nombres_pax = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->PersonName->GivenName;
            $apellidos_pax = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->PersonName->Surname;
            $tlfn_first = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone[0];
            $tlfn_second = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo->Customer->ContactPerson->Telephone[1];
            $data_get_tlfn1 = explode('D1',$tlfn_first)[1];
            $num_tlfn1 = explode('P1',$data_get_tlfn1);
            $ddi_tlfn1 = $num_tlfn1[0];
            $num_tlfn1 = $num_tlfn1[1];
            $data_get_tlfn2 = explode('D2',$tlfn_second)[1];
            $num_tlfn2 = explode('P2',$data_get_tlfn2);
            $ddi_tlfn2 = $num_tlfn2[0];
            $num_tlfn2 = $num_tlfn2[1];
            $cod_nacionalidad_pax = (empty($num_tlfn1)) ? $this->Pais_model->GetIdPais($ddi_tlfn2): $this->Pais_model->GetIdPais($ddi_tlfn1);
            
            

            echo $cod_nacionalidad_pax;die;

            
            die;
            $estado_tkt = $Itinerary->TravelItinerary->ItineraryInfo->Ticketing->attributes()->TicketingStatus;
           
            switch ((int)$estado_tkt) {
                case 1: //Pendiente de emisión
                    //Logica para mostrar el itineario
                    
                    $data['Pasajeros'] = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo;
                    $data['Itinerarios'] = $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item;
                    $data['TravelItinerary'] = $Itinerary->TravelItinerary;
                    $data['TotalPagar'] = $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
                    $this->template->load('v_pago_reservas', $data);

//                if ($TiempoValidoReProcesarReserva) {
                    if (!is_null($data['res_model_vuelo'])) {
                        $reserva_id = $data['res_model_vuelo']->id;
                        $data['paises'] = $this->Pais_model->GetDataPais('id,nombre_pais');
                        $data['cod_ddi_paises'] = $this->Pais_model->GetDataPais('codigo_pais,ddi');
                        $campos = 'nombres,apellidos,tipo_documento,num_documento,tipo_pasajero';
                        $data['res_model_pasajero'] = $this->Reserva_model->ObtenerPasajerosReserva_detalle($reserva_id, $campos);
                        $this->template->load('v_pago_reservas', $data);
                    } else {
//                        echo 2;die;
                        header("Location: " . base_url());
                    }
//                } else {
////                    echo 3;die;
//                    header("Location: " . base_url().'html/web/tiempo_limite_reserva.html');
////                    header("Location: " . base_url());
//                }
            } else {
                // Aqui mostrar un aviso que la reserva ya fue pagada
//                echo "reserva ya pagada";
                header("Location: " . base_url().'html/web/reserva_pagada.html');
            }
        }
    }

    public function ReprocesarPago()
    {
        $pnr = $_GET['pnr'];
        $reserva_id = $_GET['reserva_id'];
        $data['res_model_vuelo'] = $this->Reserva_model->BuscarReserva($reserva_id, NULL, 'reserva_id');
        $TiempoValidoReProcesarReserva = RetornaHorasDiferencias($data['res_model_vuelo']->fecha_limite);


        if ($TiempoValidoReProcesarReserva) {
            if (!is_null($data['res_model_vuelo'])) {
                $reserva_id = $data['res_model_vuelo']->id;
                $campos = 'nombres,apellidos,tipo_documento,num_documento,tipo_pasajero';
                $data['res_model_pasajero'] = $this->Reserva_model->ObtenerPasajerosReserva_detalle($reserva_id, $campos);
                $data['paises'] = $this->Pais_model->GetDataPais('id,nombre_pais');
                $data['cod_ddi_paises'] = $this->Pais_model->GetDataPais('codigo_pais,ddi');
                $this->template->load('v_pago_reservas', $data);
            } else {
                header("Location: " . base_url() . 'html/web/tiempo_limite_reserva.html');
            }
        } else {
            header("Location: " . base_url());
        }
    }
}
