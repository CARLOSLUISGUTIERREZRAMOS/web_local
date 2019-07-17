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
        $this->load->helper('kiu');
        $this->load->helper('reserva');
        $this->load->helper('geolocalizacion');

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
            /* $Itinerary_xml = $kiu->TravelItineraryReadRQ($args, $err)[2]; //CAPTURADO COMO XML */
            echo "<pre>";
            var_dump($Itinerary);
            echo "</pre>";

            $estado_tkt = $Itinerary->TravelItinerary->ItineraryInfo->Ticketing->attributes()->TicketingStatus;
            switch ((int)$estado_tkt) {
                case 1: //Pendiente de emisión
                    //********************* REGISTRANDO UNA VENTA OBTENIDA DE CALL CENTER *******************
                    $res_array_insert = FormarArregloInsert_ModuloPagoReservas($Itinerary);
                    // var_dump($res_array_insert);die;
                    //Antes de registrar validamos que la reserva o pnr no se encuentre registrado en la DB StarPeru 
                    $pnr = (string)$Itinerary->TravelItinerary->ItineraryRef->attributes()->ID;
                    $cantidad_registros = $this->Reserva_model->VerificarExisteReserva(array('pnr' => $pnr));
                    
                    if ($cantidad_registros === 0) {
                        $insert_id_reserva = $this->Reserva_model->RegistrarReserva($res_array_insert);
                   
                    } else {
                        $insert_id_reserva = $this->Reserva_model->BuscarIdReservaPorPnr($pnr);
                    }

                    foreach ($Itinerary->TravelItinerary->CustomerInfos->CustomerInfo as $Pasajero) {
                        $data_reserva_detalle = [];
                        $tipo_pax = (string)$Pasajero->Customer->attributes()->PassengerTypeCode;
                        $data_reserva_detalle['tipo_pasajero'] = (string)$Pasajero->Customer->attributes()->PassengerTypeCode;
                        $data_reserva_detalle['nombres'] = (string)$Pasajero->Customer->PersonName->Surname;
                        $data_reserva_detalle['apellidos'] = (string)$Pasajero->Customer->PersonName->GivenName;
                        $data_reserva_detalle['tipo_documento'] = (string)$Pasajero->Customer->Document->attributes()->DocType;
                        $data_reserva_detalle['num_documento'] = (string)$Pasajero->Customer->Document->attributes()->DocID;
                        $data_reserva_detalle['pnr'] = (string)$Itinerary->TravelItinerary->ItineraryRef->attributes()->ID;
                        
                        $data_reserva_detalle['nacionalidad'] = $res_array_insert['nacionalidad'];
                        $data_reserva_detalle['reserva_id'] = $insert_id_reserva;
                        $res = $this->Reserva_model->RegistrarReservaDetalle($data_reserva_detalle);
                        //echo $res;

                    }

                    //********************* .REGISTRANDO UNA VENTA OBTENIDA DE CALL CENTER *******************

                    //************ BLOQUE QUE RENDERIZA LA VISTA MOSTRANDO EL ITINERARIO DEL O LOS PASAJEROS *********
                    
                    $data['Pasajeros'] = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo;
                    $data['Itinerarios'] = $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item;
                    $data['ruc'] = (isset($Itinerary->TravelItinerary->Remarks)) ? (string)$Itinerary->TravelItinerary->Remarks->Remark : "";
                    $data['TravelItinerary'] = $Itinerary->TravelItinerary;
                    $data['TotalPagar'] = $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
                    $data['reserva_id'] = $insert_id_reserva;
                    $this->template->load('v_pago_reservas', $data);

                    break;
                case 3: //Ticket emitido
                    header("Location: " . base_url() . 'html/web/reserva_pagada.html');
                    break;
                case 5: //Ticket Cancelado
                    header("Location: " . base_url() . 'html/web/tiempo_limite_reserva.html');
                    break;
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
