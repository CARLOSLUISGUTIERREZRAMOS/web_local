<?php

/**
 * Description of AppVisa
 *
 * @author cgutierrez
 */
class TicketStarPeru extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('kiu/Controller_kiu');
    }

    public function MostrarTicket() {

        $ticket = $_POST['number_ticket'];
        $kiu = new Controller_kiu();
        $res_ticket = $kiu->TravelItineraryReadRQ(array('IdTicket' => $ticket), $err)[0];


        if (isset($res_ticket['Error'])) {
            if ($res_ticket['Error']['ErrorCode'] != 0) {
                /* MOSTRAR PANTALLA DE ERROR */
                echo $res_ticket['Error']['ErrorCode'] . " - " . $res_ticket['Error']['ErrorMsg'];
                die;
            }
        }

        if (count($res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"]) == 0) {
            echo $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"] = 'N&Uacute;MERO DE TICKET INV&Aacute;LIDO, EL TICKET HA SIDO ANULADO./ INVALID TICKET NUMBER';
        }

        echo $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"];
    }

}
