<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Booking2 extends CI_Controller
{
    protected $dispositivo_movil = TRUE;
    protected $precio_subtotal;
    protected $precio_total;

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('form_validation','kiu/Controller_kiu'));
        $this->load->helper(array('security','itinerario','tiempos','validaciones','reserva','bloqueshtml'));
        $this->load->model(array('Pais_model','Descuento_model'));
        $this->template->add_js('https://cdn.viajala.com/tracking/conversion.js');
    }

    private function ValidarPostInput()
    {
        $this->form_validation->set_rules('grupo_ida', 'El vuelo de ida debe ser seleccionado', 'required|trim|xss_clean');
        $this->form_validation->set_rules('cod_origen', 'El Origen no fue seleccionado', 'min_length[3]|max_length[3]|required|xss_clean');
        $this->form_validation->set_rules('cod_destino', 'El Destino no fue seleccionado', 'min_length[3]|max_length[3]|xss_clean');
        $this->form_validation->set_rules('tipo_viaje', 'Tipo de Viaje', 'required|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_adl', 'Adultos', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_chd', 'Niños', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_inf', 'Bebes', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        //        $this->form_validation->set_rules('fecha_retorno', 'Fecha de retorno', array('regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]', 'min_length[10]', 'max_length[10]', 'required'));
    }
//llamado desde pasodos.js
    public function GetCodigoDescuento()
    {

        //1 Recibiendo post desde pasodos.js
        $codigo_descuento_ingresado = $_POST['cod_desc'];
        //2. Obtenemeos infomacion de nuestra db respecto al codigo descuento.
        $res_sql_descuento = $this->Descuento_model->GetDataCodigoDescuento($codigo_descuento_ingresado);
        //3. Validamos que el codigo recibido este registrado y vigente en nuestra db.
        if (is_null($res_sql_descuento)) {
            //3.2 Avisamos que el código no está vigente o no es válido
            echo 'FALSE';
        } else {
            //3.2 Enviamos al js la data necesaria para continuar el flujo
            echo $res_sql_descuento->codigo . '|' . $res_sql_descuento->monto .'|'. $res_sql_descuento->id;
        }
    }

    public function index()
    {


        
        $this->template->add_js('js/web/pasodos.js?1.5.0'); //?1.0.0  -> Para no cachear 
        $this->ValidarPostInput();
        if ($this->form_validation->run() == FALSE) {
            header("Location: https://www.starperu.com");
        } else {
            $xss_post = $this->input->post(NULL, TRUE);
            $BoolValCantPax = ValidarCantidadMaxPax($xss_post['cant_adl'], $xss_post['cant_chd'], $xss_post['cant_inf']);
            $res_itinerario = ArmarItinerario($xss_post);
            $trama = $this->ArmaTramaWsKiu($res_itinerario, $xss_post['cant_adl'], $xss_post['cant_chd'], $xss_post['cant_inf']);
            $rs_kiu = $this->EnviarTramakiu($trama);
            
            $rs_kiu = $rs_kiu[3];
            if (isset($rs_kiu->Error)) {
                $data['codigo_error'] = $rs_kiu->Error->ErrorCode;
                $data['msg_error'] = $rs_kiu->Error->ErrorMsg;
                $this->load->view('templates/v_error_controller', $data);
            } else {
                $data = $this->ProcesarXmlKiu($rs_kiu);
                
                $data = FormarArrayVistaBooking2($xss_post,$data);
                // var_dump($data);die;
                $data['paises'] = $this->Pais_model->GetDataPais('id,nombre_pais');
                $data['cod_ddi_paises'] = $this->Pais_model->GetDataPais('codigo_pais,ddi');

                // ************* LOGICA APLICAR CODIGO DESCUENTO ***************

                // $clases_validas = GetClase($xss_post);
                // $obj_descuento = $this->Descuento_model->GetMontoDescuento($xss_post['tipo_viaje'],$xss_post['cod_origen'],$xss_post['cod_destino'],$clases_validas);
                // // var_dump($obj_descuento);
                // if(!is_null($obj_descuento)){
                //     $ruta_valida = ValidarDescuento($data['cod_origen'],$data['cod_destino'],$data['tipo_viaje'],$obj_descuento->ruta);
                //     if($ruta_valida){
                //         $data_cod_desc= $obj_descuento->metodos_pago;
                //         $data['html_desc'] = ArmarBloqueCodigoDescuento($data_cod_desc);
                //         $data['TotalAplicaDesc'] = $this->OperarDescuento($rs_kiu[3], $obj_descuento);
                //     }
                // }
                // **************.LOGICA APLICAR CODIGO DESCUENTO **************

                $this->template->load('v_pasodos', $data);
                $this->load->view('politicas_negocio/terminos_condiciones');
                $this->load->view('politicas_negocio/termino_condiciones_transporte');
            }
        }
    }

 

    private function OperarDescuento($rs_kiu, $obj_descuento)
    {
        $eq_total = (double)$rs_kiu->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->ItinTotalFare->BaseFare->attributes()->Amount;
        $hw_total = (double)$rs_kiu->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->ItinTotalFare->Taxes->Tax[0]->attributes()->Amount;
        $pe_total = (double)$rs_kiu->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->ItinTotalFare->Taxes->Tax[1]->attributes()->Amount;
        $descuento_aplicado = $eq_total * ($obj_descuento->monto / 100);
        $eq_recalculado = $eq_total - $descuento_aplicado;
        $pe_recalculado = $eq_recalculado * 0.18;
        $monto_pagar_con_desc = $eq_recalculado + $pe_recalculado + $hw_total;
        return $monto_pagar_con_desc;
    }

    private function ProcesarXmlKiu($rs_kiu)
    {
        /*
         * Esta funcion será la encargada de setiar las variables
         * mas importantes en este paso
         */
        foreach ($rs_kiu->PricedItineraries as $key => $value) {
            $Itinerario = $value->PricedItinerary->AirItinerary;
            $NodosPricingInfo = $value->PricedItinerary->AirItineraryPricingInfo;
            $this->setPrecio_total((double)$NodosPricingInfo->ItinTotalFare->TotalFare->attributes()->Amount);
            $this->setPrecio_subtotal((double)$NodosPricingInfo->ItinTotalFare->BaseFare->attributes()->Amount);
            $data['v_desglose_itinerario'] = $this->ArmarDesgloseItinerario($Itinerario);
            //            $ResMetPrecTotal = $this->ObtenerPrecioTotal($NodosPricingInfo);
            $data['v_desglose_precios'] = $this->ArmarDelglosePrecios($NodosPricingInfo);
        }
        return $data;
    }

    private function EnviarTramakiu($trama)
    {
        $kiu = new Controller_kiu();
        $array_price = $kiu->AirPriceRQ($trama, $err);
        $ResKiuXML = $array_price;
        //        $ResKiuXML = $array_price;
        return $ResKiuXML;
    }

    private function ArmarDesgloseItinerario($Itinerario)
    {

        $data['Itinerario'] = $Itinerario->OriginDestinationOptions;
        //        $bloque_desglose_itinerario = $this->load->view('bloques_pasodos/v_desglose_tuvuelo',$data);
        $data['PrecioTotal'] = $this->getPrecio_total();
        $bloque_desglose_itinerario = $this->load->view('bloques_pasodos/v_desglose_tuvuelo', $data, TRUE);
        return $bloque_desglose_itinerario;
    }

    private function ArmarDelglosePrecios($Precios)
    {
        //         $cant = $Precios->PTC_FareBreakdowns->PTC_FareBreakdown;
        $data['DesglosePrecios'] = $Precios->PTC_FareBreakdowns->PTC_FareBreakdown;
        $bloque_desglose_fare = $this->load->view('bloques_pasodos/v_desglose_precios', $data, TRUE);
        return $bloque_desglose_fare;
    }

    private function ArmarItinerario($xss_post)
    {

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
                $itinerario = array(
                    array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$num_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => $xss_post['cod_origen'], 'ArrivalAirport' => $xss_post['cod_destino'], 'MarketingAirline' => "2I"),
                    array("DepartureDateTime" => "$fecha_hora_salida_retorno", "ArrivalDateTime" => "$fecha_hora_llegada_retorno", "FlightNumber" => "$num_vuelo_retorno", "ResBookDesigCode" => "$clase_retorno", "DepartureAirport" => $xss_post['cod_destino'], "ArrivalAirport" => $xss_post['cod_origen'], "MarketingAirline" => "2I")
                );
                break;
            case 'O':
                $itinerario = array(array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$num_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => $xss_post['cod_origen'], 'ArrivalAirport' => $xss_post['cod_destino'], 'MarketingAirline' => "2I"));
                break;
            default:
                echo "MOSTRAR MENSAJE DE ADVERTENCIA";
        }

        return $itinerario;
    }

    private function ArmaTramaWsKiu($itinerario, $adl, $chd, $inf)
    {
        $trama = array(
            'City' => 'LIM', 'Country' => 'PE', 'Currency' => 'USD', 'FlightSegment' => $itinerario, 'PassengerQuantityADT' => $adl, 'PassengerQuantityCNN' => $chd, 'PassengerQuantityINF' => $inf
        );
        return $trama;
    }

    function setPrecio_total($precio_total)
    {
        $this->precio_total = $precio_total;
    }

    function getPrecio_total()
    {
        return $this->precio_total;
    }

    function getPrecio_subtotal()
    {
        return $this->precio_subtotal;
    }

    function setPrecio_subtotal($precio_subtotal)
    {
        $this->precio_subtotal = $precio_subtotal;
    }
}
