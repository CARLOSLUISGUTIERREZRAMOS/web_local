<?php

/**
 * Description of Pago_reservas
 *
 * @author cgutierrez
 */
class E_ticket extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->add_js('js/web/ticket.js');
        $this->load->library('form_validation');
        $this->load->library('kiu/Controller_kiu');
        $this->load->model('Reserva_model');
        $this->load->helper('tiempos');
    }

    private function ValidarFormulario()
    {
        $this->form_validation->set_rules('codigo_reserva', 'codigo_reserva', 'trim|required|min_length[6]|max_length[6]');
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
            $Itinerary_xml = $kiu->TravelItineraryReadRQ($args, $err)[2]; //XML

            $estado_tkt = $Itinerary->TravelItinerary->ItineraryInfo->Ticketing->attributes()->TicketingStatus;

            switch ((int)$estado_tkt) {
                case 1: //Pendiente de emisión
                    
                    header("Location: " . base_url() . 'html/web/reserva_nopagada.html');
                    break;
                case 3: //Ticket emitido
                    $data['Pasajeros'] = $Itinerary->TravelItinerary->CustomerInfos->CustomerInfo;
                    $data['Itinerarios'] = $Itinerary->TravelItinerary->ItineraryInfo->ReservationItems->Item;
                    $data['TravelItinerary'] = $Itinerary->TravelItinerary;
                    $data['TotalPagar'] = $Itinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;

                    $this->template->load('v_e-ticket', $data);
                    $this->load->view('politicas_negocio/politicas_devolucion');
                    $this->load->view('politicas_negocio/terminos_condiciones');
                    $this->load->view('templates/v_modal_show_ticket');

                    break;
                case 5: //Ticket Cancelado
                    header("Location: " . base_url() . 'html/web/tiempo_limite_reserva.html');
                    break;
            }
        }
    }
}
