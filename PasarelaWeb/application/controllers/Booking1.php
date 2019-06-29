<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking1 extends CI_Controller {

    protected $QueryDB;
    protected $origen;
    protected $destino;
    protected $fecha_salida;
    protected $fecha_retorno;
    protected $tipo_viaje;
    protected $cant_adl;
    protected $cant_chd;
    protected $cant_inf;

    public function __construct() {
        parent::__construct(); // you have missed this line.
        $this->load->helper("validaciones_helper");
        $this->load->helper("aeropuertos");
        $this->load->helper("ciudades");
        $this->load->helper("security");
        $this->load->library('Geolocalizacion/geolocalizacion');
        $this->load->library('form_validation');
        $this->load->helper("tiempos");
        $this->load->library('kiu/Controller_kiu');
        $this->load->model('Ruta_model');
        $this->load->model('Ciudad_model');
        $this->load->model('Farebase_model');
        $this->template->add_js('https://cdn.viajala.com/tracking/conversion.js');
    }

    private function ValidarPostInput() {
        $this->form_validation->set_rules('origen', 'Ciudad de origen', 'required|trim|min_length[3]|max_length[3]|xss_clean');
        $this->form_validation->set_rules('destino', 'Ciudad de destino', 'required|trim|min_length[3]|max_length[3]|xss_clean');
        $this->form_validation->set_rules('date_from', 'Fecha de salida', array('regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]', 'min_length[10]', 'max_length[10]', 'required'));
        $this->form_validation->set_rules('date_to', 'Fecha de retorno', array('regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]', 'min_length[10]', 'max_length[10]', 'required'));
        $this->form_validation->set_rules('cant_adultos', 'Adultos', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_ninos', 'Niños', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('cant_infantes', 'Bebes', 'required|integer|trim|min_length[1]|max_length[1]|xss_clean');
        $this->form_validation->set_rules('tipo_viaje', 'Tipo de Viaje', 'required|trim|min_length[1]|max_length[1]|xss_clean');
        
    }

    function index() {
//        echo $ahsgdas;
        $this->template->add_js('js/web/pasouno.js');
        $this->template->add_css('css/pasouno.css');
        $from = fecha_iso_8601($_POST['date_from']);
        $to = fecha_iso_8601($_POST['date_to']);



        $fecha_entrada = strtotime(fecha_iso_8601($from));
        $fecha_date_to = strtotime(fecha_iso_8601($to));
//            echo $fecha_date_to;die;
        $fecha_hoy_sistema = (new DateTime())->format('Y-m-d');
        $fecha_sistema = strtotime($fecha_hoy_sistema);
        if ($fecha_entrada < $fecha_sistema) {
            header("Location: https://www.starperu.com");
        }
        if ($_POST['tipo_viaje'] === 'R') {
            if ($fecha_date_to < $fecha_entrada) {
                header("Location: https://www.starperu.com");
            }
        }



        $this->session->unset_userdata('pnr');
        $this->session->unset_userdata('apellidos');

        $this->ValidarPostInput();
        if ($this->form_validation->run() == FALSE) {
            header("Location: https://www.starperu.com");
        } else {
            $xss_post = $this->input->post(NULL, TRUE);
            (ValidarCantidadMaxPax($xss_post['cant_adultos'], $xss_post['cant_ninos'], $xss_post['cant_infantes'])) ? '' : header("Location: https://www.starperu.com");
            $XMLObject = $this->ObtenerDisponibilidadesDeVuelo_WSKiu($xss_post['date_from'], $xss_post['date_to'], $xss_post['origen'], $xss_post['destino'], $xss_post['tipo_viaje'], $xss_post['cant_adultos'], $xss_post['cant_ninos'], $xss_post['cant_infantes'])[3];
//            echo "<pre>";
//            var_dump($XMLObject);
//            echo "</pre>";
//            
//            die;
            $data = $this->ArmandoInformacionFiltrosDeVista($XMLObject, $xss_post);
//            var_dump($data);
            $this->template->load('v_pasouno', $data);
        }
    }

    protected function GetCantidadTotalPax($xss_post) {
        $total_adultos = (int) $xss_post['cant_adultos'];
        $total_ninos = (int) $xss_post['cant_ninos'];
        $total_infantes = (int) $xss_post['cant_infantes'];
        $total_pasajeros = $total_adultos + $total_ninos + $total_infantes;
        if ($total_pasajeros > 9) {
            /* De alguna manera esta rompiendo la validacion del lado del servidor superando los limites max del
             * total de pasajeros permitido, finalmente no le permitimos el ingreso y lo redireccionamos al main
             */
            header("Location: https://www.starperu.com");
        } else {
            return $total_pasajeros;
        }
    }

    private function ArmandoInformacionFiltrosDeVista($XMLObject, $xss_post) {

        $cant_vuelos_x_tramos = $this->GetCantidadVuelos($XMLObject); //[IDA] | [VUELTA]
        $matriz_vuelo_ida = NULL;
        $matriz_vuelo_retorno = NULL;

        switch ($xss_post['tipo_viaje']) {
            case 'O':
                if ($cant_vuelos_x_tramos['IDA'] === 0) {
                    $tarifa_menor['IDA'] = 0;
                    $mostrar_bloque_vuelos['IDA'] = FALSE;
                } else {
                    $mostrar_bloque_vuelos['IDA'] = TRUE;
                    $tramo = 'IDA';
                    $matriz_vuelos = $this->ArmaMatrizVuelos($XMLObject->OriginDestinationInformation[0], $xss_post, $xss_post['origen'], $xss_post['destino'], NULL, NULL, $tramo);
//                      return $matriz_vuelos;
                    if (isset($matriz_vuelos->$xss_post['origen']) && !empty($matriz_vuelos)) {
                        $matriz_vuelo_ida = $matriz_vuelos->$xss_post['origen'];

//                        var_dump($matriz_vuelos);die;
                        $tarifa_menor['IDA'] = $this->GetFareMenorAllFlights($matriz_vuelos->$xss_post['origen']);
                    } else {
                        $tarifa_menor['IDA'] = 0;
                        $mostrar_bloque_vuelos['IDA'] = FALSE;
                    }
                }
                break;
            case 'R':
                $estadia_dias = calcular_estadia(fecha_iso_8601($xss_post['date_from']), fecha_iso_8601($xss_post['date_to']));
                if ($cant_vuelos_x_tramos['IDA'] === 0) {

                    $tarifa_menor['IDA'] = 0;
                    $mostrar_bloque_vuelos['IDA'] = FALSE;
                } else if ($cant_vuelos_x_tramos['IDA'] > 0) {
                    $mostrar_bloque_vuelos['IDA'] = TRUE;
                    $tramo = 'IDA';
                    $NumDiaSem = date_format(date_create(fecha_iso_8601($xss_post['date_from'])), 'w');
                    $matriz_vuelos = $this->ArmaMatrizVuelos($XMLObject->OriginDestinationInformation[0], $xss_post, $xss_post['origen'], $xss_post['destino'], $estadia_dias, $NumDiaSem, $tramo);
//                    var_dump($matriz_vuelos);die;
//                    return $matriz_vuelos;
//                    die;
                    if (isset($matriz_vuelos->$xss_post['origen']) && !empty($matriz_vuelos)) {
                        $matriz_vuelo_ida = $matriz_vuelos->$xss_post['origen'];
//                        echo "<pre>";
//                        var_dump($matriz_vuelo_ida);
//                        echo "</pre>";die;
                        $tarifa_menor['IDA'] = $this->GetFareMenorAllFlights($matriz_vuelos->$xss_post['origen']);
//                        die;
                    } else {
                        $tarifa_menor['IDA'] = 0;
                        $mostrar_bloque_vuelos['IDA'] = FALSE;
                    }
                }
                if ($cant_vuelos_x_tramos['RETORNO'] === 0) {
                    $tarifa_menor['RETORNO'] = 0;
                    $mostrar_bloque_vuelos['RETORNO'] = FALSE;
                } else if ($cant_vuelos_x_tramos['RETORNO'] > 0) {
                    $tramo = 'RETORNO';
                    $mostrar_bloque_vuelos['RETORNO'] = TRUE;

                    $restadias = '-' . $estadia_dias . ' days';
                    $NumDiaSem = date('w', strtotime($xss_post['date_to'] . $restadias));

                    $matriz_vuelos = $this->ArmaMatrizVuelos($XMLObject->OriginDestinationInformation[1], $xss_post, $xss_post['destino'], $xss_post['origen'], $estadia_dias, $NumDiaSem, $tramo);
//                      echo '<pre>';
//                     print_r($XMLObject);
//                     echo '</pre>';die;    
                    if (isset($matriz_vuelos->$xss_post['destino']) && !empty($matriz_vuelos)) {
                        $matriz_vuelo_retorno = $matriz_vuelos->$xss_post['destino'];
//                        echo "<pre>";
//                        var_dump($matriz_vuelo_retorno);
//                        echo "</pre>";
                        $tarifa_menor['RETORNO'] = $this->GetFareMenorAllFlights($matriz_vuelos->$xss_post['destino']);
                    } else {
                        $tarifa_menor['RETORNO'] = 0;
                        $mostrar_bloque_vuelos['RETORNO'] = FALSE;
                    }
                }
                break;
        }
        return $this->ArmarDataVista($xss_post, $mostrar_bloque_vuelos, $tarifa_menor, $matriz_vuelo_ida, $matriz_vuelo_retorno);
    }

    protected function ArmarDataVista($xss_post, $mostrar_bloque_vuelos, $tarifa_menor, $matriz_vuelo_ida, $matriz_vuelo_retorno = NULL) {
//        $data['CantTotalPax'] = 
//            print_r($xss_post);die;
        $data = array();
        $data['tipo_viaje'] = $xss_post['tipo_viaje'];
        $data['date_from'] = $xss_post['date_from'];
        $data['date_to'] = $xss_post['date_to'];
        $data['cant_adultos'] = $xss_post['cant_adultos'];
        $data['cant_ninos'] = $xss_post['cant_ninos'];
        $data['cant_infantes'] = $xss_post['cant_infantes'];
        if (isset($xss_post['position']) && !empty($xss_post['position'])) {
            $data['valueset_position'] = $xss_post['position'];
        }
        $data['geoip_pais'] = $this->GetPaisCiudadGeoIp()['PAIS'];
        $data['geoip_ciudad'] = $this->GetPaisCiudadGeoIp()['CIUDAD'];
        $nombre_ciudad_origen = ObtenerNombreCiudad($xss_post['origen']);
        $nombre_ciudad_destino = ObtenerNombreCiudad($xss_post['destino']);
        $data['data_ida'] = array("origen" => $xss_post['origen'], "nom_ciudad_orig" => $nombre_ciudad_origen, "destino" => $xss_post['destino'], "nom_ciudad_dest" => $nombre_ciudad_destino, "date_from" => $xss_post['date_from'], "date_to" => $xss_post['date_to'],
            "mostrar_bloque_vuelos" => $mostrar_bloque_vuelos['IDA'], "tarifa_menor" => $tarifa_menor['IDA']);
        if (!is_null($matriz_vuelo_ida)):
            $data['data_ida']['json'] = $matriz_vuelo_ida;
            $data['data_ida']['CantTotalPax'] = $this->GetCantidadTotalPax($xss_post);
//            array_push($data['data_ida'], $matriz_vuelo_ida);
        endif;
        if ($data['tipo_viaje'] === 'R'):
            $data['data_retorno'] = array("origen" => $xss_post['destino'], "nom_ciudad_orig" => $nombre_ciudad_destino, "destino" => $xss_post['origen'], "nom_ciudad_dest" => $nombre_ciudad_origen, "date_to" => $xss_post['date_to'], "date_from" => $xss_post['date_from'],
                "mostrar_bloque_vuelos" => $mostrar_bloque_vuelos['RETORNO'], "tarifa_menor" => $tarifa_menor['RETORNO']);
            if (!is_null($matriz_vuelo_retorno)):
                $data['data_retorno']['json'] = $matriz_vuelo_retorno;
                $data['data_retorno']['CantTotalPax'] = $this->GetCantidadTotalPax($xss_post);
//                array_push($data['data_retorno'], $matriz_vuelo_retorno);
            endif;
        endif;
        return $data;
    }

    function ObtenerVuelosDisponiblesKiu() {
        
    }

    private function ArmaMatrizVuelos($XmlKiu, $xss_post, $cod_origen, $cod_destino, $estadia_dias, $NumDiaSem, $tramo) {

        $pais = $this->GetPaisCiudadGeoIp()['PAIS'];
        $data = array();
        $i = 0;  // IDA 
        $cantidad_pax = $this->GetCantidadTotalPax($xss_post);
//        echo $cantidad_pax;die;
//        
//        
//        foreach ($XmlKiu->OriginDestinationInformation as $OriginDestinationInformation) { //BUCLE 1 | PRINCIPAL
        $OriginLocation = $cod_origen;
        $DestinationLocation = $cod_destino;
        $res_farebase_model = $this->Farebase_model->GetTarifas($OriginLocation, $DestinationLocation, $xss_post, $pais, $estadia_dias, $NumDiaSem, $tramo);
//        return $res_farebase_model;
//        echo $res_farebase_model;die;
        foreach ($XmlKiu->OriginDestinationOptions as $OriginDestinationOptions) { //BUCLE 2
            foreach ($OriginDestinationOptions->OriginDestinationOption as $OriginDestinationOption) {
                $hora_salida = (new DateTime($OriginDestinationOption->FlightSegment->attributes()->DepartureDateTime))->format('Y-m-d H:i:s');
//                $TiempoCompraValido = CalcularDiferenciaDiaHoraVuelo($hora_salida);

                $format_date_iso = 'Y-m-d H:i:s';
                $hora_sistema = (new DateTime())->format($format_date_iso);
                $TiempoCompraValido = diferencia_hora_vuelo_kiu($hora_salida, $hora_sistema);

//                echo "<pre>";
//                var_dump($TiempoCompraValido);
//                echo "</pre>";

                if ($TiempoCompraValido) {
                    foreach ($OriginDestinationOption->FlightSegment as $FlightSegment) {
                        $FlightNumber = (string) $FlightSegment->attributes()->FlightNumber;
                        $DepartureDateTime = (string) $FlightSegment->attributes()->DepartureDateTime;
                        $ArrivalDateTime = (string) $FlightSegment->attributes()->ArrivalDateTime;
                        $JourneyDuration = (string) $FlightSegment->attributes()->JourneyDuration;
                        $Code = (isset($FlightSegment->OperatingCarrier)) ? $FlightSegment->OperatingCarrier->attributes()->Code : '';
                        foreach ($FlightSegment->BookingClassAvail as $BookingClassAvail) {
                            $clase_ws = $BookingClassAvail->attributes()->ResBookDesigCode;
                            $clase_cap = $BookingClassAvail->attributes()->ResBookDesigCode;
                            $disponible = $BookingClassAvail->attributes()->ResBookDesigQuantity;
//                                if ($disponible >= $CantTotalPax) {
                            $tarifa_menor = 0;
                            foreach ($res_farebase_model->result() as $campo) {


                                if ($clase_ws == $campo->clase && $disponible >= $cantidad_pax) {
//                                        echo $clase_ws .'  '. $campo->tarifa.' '. $campo->clase.''.$cantidad_pax;
                                    $tarifa_menor = $campo->tarifa;

                                    $tarifa_menor = $this->GetTarifaMenor($tarifa_menor, $campo);
//                                        echo "<br>";


                                    $data["$OriginLocation"]["$FlightNumber"]['DepartureDateTime'] = $DepartureDateTime;
                                    $data["$OriginLocation"]["$FlightNumber"]['ArrivalDateTime'] = $ArrivalDateTime;
                                    $data["$OriginLocation"]["$FlightNumber"]['JourneyDuration'] = $JourneyDuration;
                                    if (!empty($Code)) {
                                        $data["$OriginLocation"]["$FlightNumber"]['Code'] = (string) $Code;
                                    }
                                    switch ($campo->familia) {
                                        case 'PROMO':
//                                                if ((int) $disponible >= $CantTotalPax) {
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Tarifa'] = (string) $tarifa_menor;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Clase'] = (string) $campo->clase;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['ResBookDesigQuantity'] = (string) $disponible;
                                            $PROMO = TRUE;
//                                                }
                                            break;
                                        case 'SIMPLE':
//                                                if ((int) $disponible >= $CantTotalPax) {
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Tarifa'] = (string) $tarifa_menor;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Clase'] = (string) $campo->clase;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['ResBookDesigQuantity'] = (string) $disponible;
                                            $SIMPLE = TRUE;
//                                                }
                                            break;
                                        case 'EXTRA':
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Tarifa'] = (string) $tarifa_menor;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Clase'] = (string) $campo->clase;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['ResBookDesigQuantity'] = (string) $disponible;
                                            $EXTRA = TRUE;
                                            break;
                                        case 'FULL':
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Tarifa'] = (string) $tarifa_menor;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['Clase'] = (string) $campo->clase;
                                            $data["$OriginLocation"]["$FlightNumber"]['FAMILIA'][$campo->familia]['ResBookDesigQuantity'] = (string) $disponible;
                                            $FULL = TRUE;
                                            break;
                                    }
                                }
                            }
                        }
//                            }
                    }
                }
//                }
            }
            $i++;
        }
        return json_decode(json_encode($data));
    }

    private function GetFareMenorAllFlights($ObjSabana) {

        $tarifa_menor_total = array();

        foreach ($ObjSabana as $dataflight) {
            foreach ($dataflight->FAMILIA as $key => $value) {
                switch (trim($key)) {
                    case 'PROMO':
                        array_push($tarifa_menor_total, $value->Tarifa);
                        break;
                    case 'SIMPLE':
                        array_push($tarifa_menor_total, $value->Tarifa);
                        break;
                    case 'EXTRA':
                        array_push($tarifa_menor_total, $value->Tarifa);
                        break;
                    case 'FULL':
                        array_push($tarifa_menor_total, $value->Tarifa);
                        break;
                }
            }
        }
        return min($tarifa_menor_total);
    }

    private function GetCantidadVuelos($XmlKiu) {
        $data = array();
        $tramo = 'IDA';
        foreach ($XmlKiu->OriginDestinationInformation as $OriginDestinationInformation) {
            $data[$tramo] = count($OriginDestinationInformation->OriginDestinationOptions->OriginDestinationOption);
            $tramo = 'RETORNO';
        }
        return $data;
    }

    protected function GetTarifaMenor($tarifa_menor, $campo) {
        $tarifa_menor = ((int) $tarifa_menor < (int) $campo->tarifa) ? $tarifa_menor : $campo->tarifa;
        return $tarifa_menor;
    }

    private function ObtenerDisponibilidadesDeVuelo_WSKiu($date_from, $date_to, $cod_origen, $cod_destino, $tipo_viaje, $cant_adt, $cant_nino, $cant_inf) {
        $trama = array(
            'Direct' => 'true'
            , 'Fecha_salida' => fecha_iso_8601($date_from)
            , 'Fecha_retorno' => fecha_iso_8601($date_to)
            , 'Source' => $cod_origen
            , 'Dest' => $cod_destino
            , 'TipoVuelo' => $tipo_viaje
            , 'Cabin' => 'Economy'
            , 'QuantityADT' => $cant_adt
            , 'QuantityCNN' => $cant_nino
            , 'QuantityINF' => $cant_inf);
        $kiu = new Controller_kiu();
        $res = $kiu->AirAvailRQ($trama, $err);
        return $res;
        $xml = $res[3];
        $xml_puro = $res[2];
//        return $xml_puro;
        return $xml_puro;
    }

    protected function ObtenerCantidadesVuelo($tipo_viaje, $xml) {

        if ($tipo_viaje === 'R') {
            foreach ($xml->OriginDestinationInformation as $nodo) {
                $vuelos_disponibles[] = count($nodo->OriginDestinationOptions->OriginDestinationOption);
            }
        } else if ($tipo_viaje === 'O') {
            $vuelos_disponibles = count($xml->OriginDestinationInformation->OriginDestinationOptions->OriginDestinationOption);
        }
        return $vuelos_disponibles;
    }

    protected function GetPaisCiudadGeoIp() {
        $pais_ciudad = array();
        $ip = $_SERVER["REMOTE_ADDR"];
        $geo = new Geolocalizacion();
        $res_ip = $geo->geo_ciudad_pais($ip);
        $arrayGeo = explode('|||', $res_ip);
        $pais_ciudad['PAIS'] = trim($arrayGeo[1]);
        $ciudadPais = trim($arrayGeo[0]);
        $splitCiudad = explode(',', $ciudadPais);
        $pais_ciudad['CIUDAD'] = trim($splitCiudad[0]);
        return $pais_ciudad;
    }

}
