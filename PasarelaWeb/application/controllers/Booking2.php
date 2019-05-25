<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking2 extends CI_Controller {

    protected $precio_subtotal;
    protected $precio_total;

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper("security");
        $this->load->helper("itinerario");
        $this->load->helper('tiempos');
        $this->load->library('kiu/Controller_kiu');
        $this->load->helper("validaciones_helper");
        $this->load->model('Pais_model');
        $this->template->add_js('https://cdn.viajala.com/tracking/conversion.js');
    }

    private function ValidarPostInput() {
        $this->form_validation->set_rules('grupo_ida', 'El vuelo de ida debe ser seleccionado', 'required|trim|xss_clean');
//        $this->form_validation->set_rules('grupo_retorno', 'El vuelo de retorno debe ser seleccionado', 'required|trim|xss_clean');
        $this->form_validation->set_rules('cod_origen', 'El Origen no fue seleccionado', 'min_length[3]|max_length[3]|required|xss_clean');
        $this->form_validation->set_rules('cod_destino', 'El Destino no fue seleccionado', 'min_length[3]|max_length[3]|xss_clean');
        $this->form_validation->set_rules('tipo_viaje', 'Tipo de Viaje', 'required|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_adl', 'Adultos', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_chd', 'Niños', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_inf', 'Bebes', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
//        $this->form_validation->set_rules('fecha_ida', 'Fecha de ida', array('regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]', 'min_length[10]', 'max_length[10]', 'required'));
//        $this->form_validation->set_rules('fecha_retorno', 'Fecha de retorno', array('regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]', 'min_length[10]', 'max_length[10]', 'required'));
    }

    public function index() {
        $this->template->add_js('js/web/pasodos.js');
        $this->ValidarPostInput();
        if ($this->form_validation->run() == FALSE) {
            header("Location: https://www.starperu.com");
        } else {
            $xss_post = $this->input->post(NULL, TRUE);
//            print_r($xss_post);die;
            $BoolValCantPax = ValidarCantidadMaxPax($xss_post['cant_adl'], $xss_post['cant_chd'], $xss_post['cant_inf']);
            $res_itinerario = ArmarItinerario($xss_post);

            $trama = $this->ArmaTramaWsKiu($res_itinerario, $xss_post['cant_adl'], $xss_post['cant_chd'], $xss_post['cant_inf']);
            $rs_kiu = $this->EnviarTramakiu($trama);

//            echo "<pre>";
//            var_dump($rs_kiu);
//            echo "</pre>";die;
            if (isset($rs_kiu->Error)) {
                $data['codigo_error'] = $rs_kiu->Error->ErrorCode;
                $data['msg_error'] = $rs_kiu->Error->ErrorMsg;

                $this->load->view('templates/v_error_controller', $data);
            } else {
                $data = $this->ProcesarXmlKiu($rs_kiu);

                $data['cant_adl'] = (int) $xss_post['cant_adl'];
                $data['cant_chd'] = (int) $xss_post['cant_chd'];
                $data['cant_inf'] = (int) $xss_post['cant_inf'];
                $data['grupo_ida'] = $xss_post['grupo_ida'];
                $data['datetime_departure'] = explode('|', $data['grupo_ida'])[3];
                $data['tipo_viaje'] = $xss_post['tipo_viaje'];
                $data['cod_origen'] = $xss_post['cod_origen'];
                $data['cod_destino'] = $xss_post['cod_destino'];
                $data['geoip_pais'] = $xss_post['geoip_pais'];
                $data['geoip_ciudad'] = $xss_post['geoip_ciudad'];
                $data['grupo_retorno'] = '';
                if ($xss_post['tipo_viaje'] === 'R'):
                    $data['grupo_retorno'] = $xss_post['grupo_retorno'];
                endif;
                $data['paises'] = $this->Pais_model->GetDataPais('id,nombre_pais');
                $data['cod_ddi_paises'] = $this->Pais_model->GetDataPais('codigo_pais,ddi');
                $this->template->load('v_pasodos', $data);
                $this->load->view('politicas_negocio/terminos_condiciones');
                $this->load->view('politicas_negocio/termino_condiciones_transporte');
            }
        }
    }

    private function ProcesarXmlKiu($rs_kiu) {
        /*
         * Esta funcion será la encargada de setiar las variables
         * mas importantes en este paso
         */
        foreach ($rs_kiu->PricedItineraries as $key => $value) {
            $Itinerario = $value->PricedItinerary->AirItinerary;
            $NodosPricingInfo = $value->PricedItinerary->AirItineraryPricingInfo;
            $this->setPrecio_total((double) $NodosPricingInfo->ItinTotalFare->TotalFare->attributes()->Amount);
            $this->setPrecio_subtotal((double) $NodosPricingInfo->ItinTotalFare->BaseFare->attributes()->Amount);
            $data['v_desglose_itinerario'] = $this->ArmarDesgloseItinerario($Itinerario);
//            $ResMetPrecTotal = $this->ObtenerPrecioTotal($NodosPricingInfo);
            $data['v_desglose_precios'] = $this->ArmarDelglosePrecios($NodosPricingInfo);
        }
        return $data;
    }

    private function EnviarTramakiu($trama) {
        $kiu = new Controller_kiu();
        $array_price = $kiu->AirPriceRQ($trama, $err);
        $ResKiuXML = $array_price[3];
//        $ResKiuXML = $array_price;
        return $ResKiuXML;
    }

    private function ArmarDesgloseItinerario($Itinerario) {

        $data['Itinerario'] = $Itinerario->OriginDestinationOptions;
//        $bloque_desglose_itinerario = $this->load->view('bloques_pasodos/v_desglose_tuvuelo',$data);
        $data['PrecioTotal'] = $this->getPrecio_total();
        $bloque_desglose_itinerario = $this->load->view('bloques_pasodos/v_desglose_tuvuelo', $data, TRUE);
        return $bloque_desglose_itinerario;
    }

    private function ArmarDelglosePrecios($Precios) {
//         $cant = $Precios->PTC_FareBreakdowns->PTC_FareBreakdown;
        $data['DesglosePrecios'] = $Precios->PTC_FareBreakdowns->PTC_FareBreakdown;
        $bloque_desglose_fare = $this->load->view('bloques_pasodos/v_desglose_precios', $data, TRUE);
        return $bloque_desglose_fare;
    }

    private function ArmarItinerario($xss_post) {

        $data_ida = explode('|', $xss_post['grupo_ida']);
        // Indice 1 => Hace referencia a la clase
        // Indice 2 => Hace referencia al numero de vuelo
        $clase_ida = $data_ida[1];
        $num_vuelo_ida = $data_ida[2];
        $fecha_hora_salida_ida = $data_ida[4];
        $fecha_hora_llegada_ida = $data_ida[3];

        switch ($xss_post['tipo_viaje']) {
            case 'R':
                $data_retorno = explode('|', $xss_post['grupo_retorno']);
                $clase_retorno = $data_retorno[1];
                $num_vuelo_retorno = $data_retorno[2];
                $fecha_hora_salida_retorno = $data_retorno[3];
                $fecha_hora_llegada_retorno = $data_retorno[4];
                $itinerario = array(array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$num_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => $xss_post['cod_origen'], 'ArrivalAirport' => $xss_post['cod_destino'], 'MarketingAirline' => "2I"),
                    array("DepartureDateTime" => "$fecha_hora_salida_retorno", "ArrivalDateTime" => "$fecha_hora_llegada_retorno", "FlightNumber" => "$num_vuelo_retorno", "ResBookDesigCode" => "$clase_retorno", "DepartureAirport" => $xss_post['cod_destino'], "ArrivalAirport" => $xss_post['cod_origen'], "MarketingAirline" => "2I"));
                break;
            case 'O':
                $itinerario = array(array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$num_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => $xss_post['cod_origen'], 'ArrivalAirport' => $xss_post['cod_destino'], 'MarketingAirline' => "2I"));
                break;
            default : echo "MOSTRAR MENSAJE DE ADVERTENCIA";
        }

        return $itinerario;
    }

    private function ArmaTramaWsKiu($itinerario, $adl, $chd, $inf) {
        $trama = array(
            'City' => 'LIM'
            , 'Country' => 'PE'
            , 'Currency' => 'USD'
            , 'FlightSegment' => $itinerario
            , 'PassengerQuantityADT' => $adl
            , 'PassengerQuantityCNN' => $chd
            , 'PassengerQuantityINF' => $inf
        );
        return $trama;
    }

    function setPrecio_total($precio_total) {
        $this->precio_total = $precio_total;
    }

    function getPrecio_total() {
        return $this->precio_total;
    }

    function getPrecio_subtotal() {
        return $this->precio_subtotal;
    }

    function setPrecio_subtotal($precio_subtotal) {
        $this->precio_subtotal = $precio_subtotal;
    }

}
