<?php

/**
 * Description of emision
 *
 * @author cgutierrez
 */
class PasoFinal extends CI_Controller
{

    protected $visa;
    protected $fecha_hora_reserva;
    protected $Safetypay;
    protected $PagoEfectivo;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('kiu/Controller_kiu');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper("security");
        $this->load->helper("tiempos");
        $this->load->helper("telefonos");
        $this->load->helper("itinerario");
        $this->load->helper("visa");
        $this->load->helper("kiu");
        $this->load->helper("caracteres_espec");
        $this->load->library('Detector/Mobile_Detect');
        $this->load->helper('logsystemweb');
        $this->load->model('Reserva_model');
        $this->load->model('Pais_model');
    }

    private function ValidarPostInput()
    {

        $this->form_validation->set_rules('email', 'Email no coincide', 'trim|required|valid_email');
        $this->form_validation->set_rules('email_rep', 'Email no coincide', 'trim|required|valid_email|matches[email]');
        $this->form_validation->set_rules('tipo_documento_adl_1', 'Tipo Documento no definido', 'trim|required|max_length[20]');
    }

    public function index()
    {

        $this->ValidarPostInput();
        if ($this->form_validation->run() == FALSE) {
            header("Location: " . base_url() . "html/web/error_seguridad_sistema.html");
        } else {

            $session_pnr = $this->session->has_userdata('pnr');
            /*  if (isset($session_pnr) && $session_pnr === true) {
                header("Location: " . base_url() . 'PagoReservas/Sugerir/');
                die;
            } */
            //            echo  $_POST['tipo_documento_adl_1'];die;
            $detect = new Mobile_Detect();
            $xss_post = $this->input->post(NULL, TRUE);
            $xss_post['dispositivo'] = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer ');
            $matriz_itinerario = ArmarItinerario($xss_post);
            $codigo_compartido = ObtenerCodigoCompartido($xss_post);
            $FechaHoraSalida = $matriz_itinerario[0]['DepartureDateTime'];
            $matriz_pax = $this->RPH($xss_post);
            $TimeLimitTicket = $this->CalcularTiempoLimiteTicket($FechaHoraSalida);
            $TramaAirbook = $this->GenerarTramaKiu_MetodoAirBookKiu($matriz_itinerario, $matriz_pax, $xss_post, $TimeLimitTicket);
            $data_procesar = $this->EnviarTramakiuAirBook($TramaAirbook);

          /*   echo "<pre>";
            var_dump($data_procesar[1]);
            echo "</pre>";
            echo "<pre>";
            var_dump($data_procesar[2]);
            echo "</pre>"; */
            
            $ResAirBookKiu = $data_procesar[3];

            if (isset($ResAirBookKiu->Error->ErrorCode)) {
                if ((string)$ResAirBookKiu->Error->ErrorCode === '22040') {
                    //                    echo 2;
                    header("Location: " . base_url() . "html/web/error_en_cotizacion.html");
                }
                if ((string)$ResAirBookKiu->Error->ErrorCode === '11031') {
                    header("Location: " . base_url() . "html/web/error_en_documento.html");
                }
                if ((string)$ResAirBookKiu->Error->ErrorCode === '10022') {
                    header("Location: " . base_url() . "html/web/nombres_pax_identicos.html");
                }
            } else {
                $pnr = (string)$ResAirBookKiu->BookingReferenceID->attributes()->ID; // ID == CODIGO DE RESERVA o PNR
                $this->session->set_userdata('pnr', $pnr);
                $TramaItinerary = $this->GenerarTramaKiu_MetodoItineraryKiu($pnr);
                $ResWsKiuItinerary = $this->EnviarTramakiuAirItinerary($TramaItinerary);
              /*   echo "<pre>";
                var_dump($ResWsKiuItinerary[2]);
                echo "</pre>"; */

                $ObjResObjectItinerary = new SimpleXMLElement($ResWsKiuItinerary);
                $res_tarifa_tax = $this->ObtenerTarifasTax($ObjResObjectItinerary, $xss_post['cod_origen'], $xss_post['cod_destino']);
                $DatetTimeLimitReserva = new DateTime();
                $DatetTimeLimitReserva->modify('+3 hours');
                $fecha_limite = $DatetTimeLimitReserva->format('Y-m-d H:i:s');


                $xss_post['fecha_limite'] = date('c', strtotime($fecha_limite));

                $reserva_id = $this->GuardarReserva($xss_post, $pnr, $res_tarifa_tax, $codigo_compartido, $fecha_limite);

                $this->fecha_hora_reserva = (new DateTime())->format('d/m/Y H:i:s');
                $res = $this->GuardarReservaDetalle($reserva_id, $pnr, $matriz_pax);

                $objTotalPagar = $res_tarifa_tax->TOTAL_PAGAR; // ESTE VARIABLE TIENE QUE LLEGAR AL BANCO
                //DESDE AQUI
                $this->PosicionarMetodoDePago($xss_post, $objTotalPagar, $pnr, $reserva_id);
            }
        }
    }

    private function PosicionarMetodoDePago($xss_post, $total_pagar, $pnr, $reserva_id)
    {
        switch ($xss_post['cc_code']) {
            case 'TC_V': // Visa
                $this->ProcesarConVisa($total_pagar, $xss_post, $reserva_id, $pnr);
                break;
            case 'TC_D': // Diners Club
                $this->ProcesarConVisa($total_pagar, $xss_post, $reserva_id, $pnr);
                break;
            case 'SP_C': // SAFETYPAY
                $this->ProcesarConSafetyPay($total_pagar, $pnr, $reserva_id, $xss_post);
                break;
            case 'SP_I': // SAFETYPAY
                $this->ProcesarConSafetyPay($total_pagar, $pnr, $reserva_id, $xss_post);
                break;
            case 'SP_E': // SAFETYPAY
                $this->ProcesarConSafetyPay($total_pagar, $pnr, $reserva_id, $xss_post);
                break;
            case 'PP': //
                $this->ProcesarConPayPal($xss_post, $total_pagar, $pnr, $reserva_id);
                break;
            case 'PE':  // PAGO EFECTIVO | ALEX  
                $this->ProcesarConPagoEfectivo($xss_post, $total_pagar, $reserva_id);
                break;
            case 'PEB':  // PAGO EFECTIVO | ALEX  
                $this->ProcesarConPagoEfectivo($xss_post, $total_pagar, $reserva_id);
                break;
        }
    }

    private function ProcesarConPayPal($xss_post, $total_pagar, $pnr, $reserva_id)
    {
        $this->load->helper("paypal");
        $this->load->library("PayPal/Conection_paypal");
        //        echo 2;die;
        $PayPal = new Conection_paypal();
        $PayPalReturnURL = $PayPal->getPayPalReturnURL();
        $PayPalCancelURL = $PayPal->getPayPalCancelURL();
        $this->session->set_userdata('reserva_id', $reserva_id);
        $nvpStr_ = padata($xss_post, $PayPalReturnURL, $PayPalCancelURL, $pnr, $reserva_id, $total_pagar);
        $metodo = 'SetExpressCheckout';
        dispara_log($reserva_id, 'PP', $metodo, $nvpStr_, 'RQ');
        $httpParsedResponseAr = $PayPal->PPHttpPost('SetExpressCheckout', $nvpStr_);
        dispara_log($reserva_id, 'PP', $metodo, print_r($httpParsedResponseAr, true), 'RS');
        if ($httpParsedResponseAr['ACK'] === 'Success') {
            $estado = 'EXITO';
            $paypalurl = 'https://www' . $PayPal->getPayPalAmbiente() . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
            //            $this->session->set_userdata('reserva_id', $reserva_id);
            header('Location: ' . $paypalurl);
        }
    }

    private function ProcesarConSafetyPay($TotalPagar, $pnr, $reserva_id, $xss_post)
    {

        $this->load->model('SafetyPay_model');
        $this->load->library('Safetypay/Controller_safetypay');
        $this->load->library('Safetypay/Connection_safetypay');
        $this->load->helper('safetypay');

        $this->session->set_userdata('reserva_id', $reserva_id);


        $model_safetypay = new SafetyPay_model(); //
        $safetypay_conection = new Connection_safetypay();
        $this->Safetypay = new Controller_safetypay(); //

        $RequestDateTime = substr(date("c"), 0, 19);
        $CurrencyCode = "USD";
        $Amount = number_format(floatval($TotalPagar), 2, ".", "");
        $MerchantSalesID = trim($pnr) . " - " . trim($reserva_id);
        $Language = "ES";
        $TrackingCode = "";
        $timeexpirit = 3;
        $ExpirationTime = number_format($timeexpirit * 60);
        $TransactionOkURL = $safetypay_conection->GetFromSuccess();
        $TransactionErrorURL = $safetypay_conection->GetFromError();
        $SignatureKey = $safetypay_conection->GetSignatureKey();
        $data = $RequestDateTime . $CurrencyCode . $Amount . $MerchantSalesID . $Language . $TrackingCode . $ExpirationTime . $TransactionOkURL . $TransactionErrorURL . $SignatureKey;
        $SignatureHash = hash_signature($data);
        $apikey = $safetypay_conection->GetApiKey();
        $Mensaje = ArmarDataCreateExpressToken($apikey, $RequestDateTime, $CurrencyCode, $Amount, $MerchantSalesID, $Language, $TrackingCode, $ExpirationTime, $TransactionOkURL, $TransactionErrorURL, $ExpirationTime, $xss_post, $SignatureHash);

        //ACTUALIZANDO COMO UN NUEVO PROCESO DE VENTA






        $array_respuesta = $this->Safetypay->CreateExpressToken($Mensaje);
        $respuesta = ArmarDataRespuestaLogSafetypay($reserva_id, $array_respuesta);


        $metodo1 = "ArmarDataCreateExpressToken";
        $metodo2 = "ArmarDataRespuestaLogSafetypay";


        dispara_log($reserva_id, 'SP', $metodo1, print_r($Mensaje, true), 'RQ');
        dispara_log($reserva_id, 'SP', $metodo2, print_r($respuesta, true), 'RS');




        //        dispara_log($reserva_id, 'SP', $metodo2, print_r($httpParsedResponseAr, true), 'RS');

        if ($array_respuesta[0]["ExpressTokenResponse"]["ErrorManager"]["ErrorNumber"] != 0) {
            echo 'ERROR PARAMETROS';
        } else {
            $model_safetypay->insertar_campos_reserva_safetypay($reserva_id);


            $url_redirect_client = $array_respuesta[0]["ExpressTokenResponse"]["ShopperRedirectURL"];
            $url_redirect_client = $url_redirect_client . '&CountryId=PER&ChannelId=CASH';
            header("Location:" . $url_redirect_client);
        }
    }

    private function ProcesarConVisa($TotalPagar, $xss_post, $reserva_id, $pnr)
    {

        $this->template->add_js('js/queryloader2/jquery.queryloader2.min.js');
        $this->template->add_js('js/visa/logica.js');
        $this->template->add_css('css/app/visa.css');
        $this->load->library('Visa/Connection_visa');
        $this->visa = new Connection_visa();
        //============     VARIABLES POST QUE DEBEN LLEGAR PARA EL PROCESO CORRECTO CON VISANET =========
        $cod_documento = $xss_post['tipo_documento_adl_1'];
        $num_documento = $xss_post['numdoc_adl_1'];
        $ruc = $xss_post['ruc'];
        $email = $xss_post['email'];
        $origen = $xss_post['cod_origen'];
        $destino = $xss_post['cod_destino'];
        $tipo_viaje = $xss_post['tipo_viaje'];
        //. VARIABLES POST QUE DEBEN LLEGAR PARA EL PROCESO CORRECTO CON VISANET==========================
        $documentType = ObtenerCodigoDocIdentidad($cod_documento);
        $token = $this->visa->Connection();
        $IP = $_SERVER['REMOTE_ADDR'];
        $request_body = $this->visa->GenerarBody($TotalPagar, $IP);

        $visa_res = $this->visa->GenerarSesion($token, $request_body);
        /* var_dump($visa_res); */
        $objSessionVisa = json_decode($visa_res);
        //        var_dump($objSessionVisa);die;
        $libreriaJsVisa = $this->visa->GetLibreriaJSVisa();
        $data_visa = ArmarDataFormVisa($objSessionVisa->sessionKey, $TotalPagar, $this->visa->getCodigo_comercio(), $documentType, $num_documento, $reserva_id, $libreriaJsVisa);
        $DataSessionZonaVisa = ArmarDataSessionZonaPagoApiVisa($token, $reserva_id);
        $this->session->set_userdata($DataSessionZonaVisa);
        $data_vista_visa_sugerencia = array('pnr' => $pnr, 'reserva_id' => $reserva_id, 'total_pagar' => $TotalPagar, 'origen' => $origen, 'destino' => $destino, 'tipo_viaje' => $tipo_viaje);
        $this->template->load('zona_metodos_pagos/v_sugerencia_visa', $data_vista_visa_sugerencia);
        $this->load->view('zona_metodos_pagos/v_modal_form_visa', $data_visa);
    }

    private function ProcesarConPagoEfectivo($xss_post, $TotalPagar, $reserva_id)
    {

        //        echo "AAA";die;
        $this->session->set_userdata('reserva_id', $reserva_id);

        $this->load->model('PagoEfectivo_model');
        $this->load->library('PagoEfectivo/Connection_pago_efectivo');
        $this->load->helper('pagoefectivo');
        $model_PE = new PagoEfectivo_model();
        $this->PagoEfectivo = new Connection_pago_efectivo;
        $accessKey = 'OGU1ODNkNTlhZDcxNTQ4'; //SANDBOX
        //        $accessKey = 'ZDQ5MTM3MDdkODA4MzYx'; //PROD
        $id_service = 98;
        $dateRequest = date('Y-m-d\TH:i:sP');
        $language = 'es-PE';
        $type_conection = 'Web';
        //        $estado_cip = '22';
        $secretKey = 'XqP7eBlS6XE9tyArQka+C4mXWy72KySE8Nh4t1/a'; //SANDBOX
        //        $secretKey = 'ZlU80uca4wPpzOjqn/vTNN3CINh+X7HKKsH8Adxy';
        $hashstring = hash('sha256', $id_service . '.' . $accessKey . '.' . $secretKey . '.' . $dateRequest);
        $request_body = $this->PagoEfectivo->GeneraBody($accessKey, $id_service, $dateRequest, $hashstring);
        $pe_res = $this->PagoEfectivo->GeneraSolicitud($request_body);
        $objSessionPE = json_decode($pe_res, false);
        $tokenPE = $objSessionPE->data->token;
        $data_header = $this->PagoEfectivo->GeneraHeaderCIP($TotalPagar, $tokenPE, $xss_post, $reserva_id);
        //        var_dump($data_header);die;

        //        $header_cip = $this->PagoEfectivo->GeneraBodyCIP($TotalPagar, $xss_post, $reserva_id);
        $objCIP = json_decode($data_header, false);
        $cip = $objCIP->data->cip;
        $data = ArmarDataParaInsertarPE($reserva_id, $cip, $TotalPagar);
        $url_CIP = $objCIP->data->cipUrl;
        $model_PE->GuardarTransaccion($data);
        //        $model_PE->actualizar_reserva($cip, $reserva_id);
        header("Location:" . $url_CIP);
    }

    protected function ObtenerTarifasTax($ObjRSKiuItinerary, $origen, $destino)
    {
        $this->load->model('Ruta_model');

        $EXONERADO = $this->Ruta_model->VerificarRutaExonerada($origen, $destino);

        $DATA = array();
        $DATA['EQ'] = (double)$ObjRSKiuItinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountBeforeTax;
        $DATA['TOTAL'] = (double)$ObjRSKiuItinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
        foreach ($ObjRSKiuItinerary->TravelItinerary->ItineraryInfo->ItineraryPricing->Taxes->Tax as $Taxes) {
            switch ($Taxes->attributes()->TaxCode) {
                case 'HW'; //TUUA
                    $DATA['HW'] = (double)$Taxes->attributes()->Amount;
                    break;
                case 'PE'; //IGV
                    $DATA['PE'] = (double)$Taxes->attributes()->Amount;
                    break;
                default:
            }
        }
        if ($EXONERADO) {
            $DATA['TOTAL_PAGAR'] = $DATA['TOTAL'] - $DATA['PE'];
        } else {
            $DATA['TOTAL_PAGAR'] = $DATA['TOTAL'];
        }
        $JSON_TARIFAS_TAXES = json_decode(json_encode($DATA));
        return $JSON_TARIFAS_TAXES;
    }

    protected function GuardarReserva($xss_post, $pnr, $res_tarifa_tax, $codigo_compartido, $fecha_limite)
    {

        $JsonDataVuelo = $this->ObtenerDataVuelos($xss_post['grupo_ida'], $xss_post['grupo_retorno']);

        if (empty($xss_post['num_tlfn'])) {
            $xss_post['num_telefono'] = "NULL";
            $xss_post['ddi_pais_tlfn'] = "NULL";
            $xss_post['region_tlfn'] = "NULL";
        }
        if (empty($xss_post['num_cel'])) {
            $xss_post['num_celular'] = "NULL";
            $xss_post['ddi_pais_cel'] = "NULL";
            $xss_post['region_cel'] = "NULL";
        }
        if (empty($xss_post['num_cel'])) {
            $xss_post['num_celular'] = "NULL";
            $xss_post['ddi_pais_cel'] = "NULL";
            $xss_post['region_cel'] = "NULL";
        }

        $data_reserva_insert = array(
            'nombres' => $xss_post['nombres_adl_1'],
            'apellidos' => $xss_post['apellidos_adl_1'],
            'nacionalidad' => $xss_post['nacionalidad_adl_1'],
            'tipo_documento' => $xss_post['tipo_documento_adl_1'],
            'num_documento' => $xss_post['numdoc_adl_1'],
            'ddi_telefono' => $xss_post['ddi_pais_tlfn'],
            'pre_telefono' => $xss_post['region_tlfn'],
            'num_telefono' => $xss_post['num_tlfn'],
            'ddi_celular' => $xss_post['ddi_pais_cel'],
            'pre_celular' => $xss_post['region_cel'],
            'num_celular' => $xss_post['num_cel'],
            'cc_code' => $xss_post['cc_code'],
            'email' => $xss_post['email'],
            'ip' => ip2long($this->input->ip_address()),
            'geo_pais' => $xss_post['geoip_pais'],
            'geo_ciudad' => $xss_post['geoip_ciudad'],
            'ruc' => (empty($xss_post['ruc'])) ? "NULL" : $xss_post['ruc'],
            'cant_adl' => $xss_post['cant_adl'],
            'cant_chd' => $xss_post['cant_chd'],
            'cant_inf' => $xss_post['cant_inf'],
            'tipo_viaje' => $xss_post['tipo_viaje'],
            'clase_ida' => $JsonDataVuelo->clase_ida,
            'clase_retorno' => $JsonDataVuelo->clase_retorno,
            'num_vuelo_ida' => $JsonDataVuelo->num_vuelo_ida,
            'cod_compartido_vuelo_ida' => $codigo_compartido['ida'],
            'dispositivo' => $xss_post['dispositivo'],
            'num_vuelo_retorno' => $JsonDataVuelo->num_vuelo_retorno,
            'cod_compartido_vuelo_retorno' => (isset($codigo_compartido['retorno'])) ? $codigo_compartido['ida'] : NULL,
            'fecha_registro' => (new DateTime())->format('Y-m-d H:i:s'),
            'fecha_limite' => $fecha_limite,
            'fechahora_salida_tramo_ida' => $JsonDataVuelo->fechahora_salida_tramo_ida,
            'fechahora_llegada_tramo_ida' => $JsonDataVuelo->fechahora_llegada_tramo_ida,
            'fechahora_salida_tramo_retorno' => ($JsonDataVuelo->fechahora_salida_tramo_retorno == 'NULL') ? NULL : $JsonDataVuelo->fechahora_salida_tramo_retorno,
            'fechahora_llegada_tramo_retorno' => ($JsonDataVuelo->fechahora_llegada_tramo_retorno == 'NULL') ? NULL : $JsonDataVuelo->fechahora_llegada_tramo_retorno,
            'origen' => $xss_post['cod_origen'],
            'destino' => $xss_post['cod_destino'],
            'pnr' => $pnr,
            'total_pagar' => $res_tarifa_tax->TOTAL_PAGAR,
            'total' => (isset($_POST['precio_total_sin_descuento']) && !empty($_POST['precio_total_sin_descuento']))?$_POST['precio_total_sin_descuento'] :$res_tarifa_tax->TOTAL_PAGAR,
            'descuento' => (!empty($xss_post['porcentaje_descuento']) && isset($xss_post['porcentaje_descuento'])) ? $xss_post['porcentaje_descuento'] : "NULL",
            'eq' => $res_tarifa_tax->EQ,
            'hw' => $res_tarifa_tax->HW,
            'pe' => $res_tarifa_tax->PE,
        );
        $res_insert_model = $this->Reserva_model->RegistrarReserva($data_reserva_insert);
        //        var_dump($res_insert_model);die;
        return $res_insert_model;
    }

    protected function GuardarReservaDetalle($reserva_id, $pnr, $matriz_pasajeros)
    {

        foreach ($matriz_pasajeros as $pasajero) {

            $data_reserva_detalle_insert = array(
                'reserva_id' => $reserva_id,
                'pnr' => $pnr,
                'nombres' => $pasajero['Nombres'],
                'apellidos' => $pasajero['Apellidos'],
                'nacionalidad' => $pasajero['Nacionalidad'],
                'tipo_documento' => $pasajero['Tipo_Documento'],
                'num_documento' => $pasajero['Numero_Documento'],
                'tipo_pasajero' => $pasajero['Tipo_Pasajero'],
            );
            $this->Reserva_model->RegistrarReservaDetalle($data_reserva_detalle_insert);
        }
    }

    private function ObtenerDataVuelos($grupo_ida, $grupo_retorno)
    {
        $data_vuelo = array();
        $DataArrayIda = explode('|', $grupo_ida);
        $data_vuelo['clase_ida'] = $DataArrayIda[1];
        $data_vuelo['num_vuelo_ida'] = $DataArrayIda[2];
        $data_vuelo['fechahora_salida_tramo_ida'] = $DataArrayIda[3];
        $data_vuelo['fechahora_llegada_tramo_ida'] = $DataArrayIda[4];
        //        }else{
        if (empty($grupo_retorno)) {
            //Si ingresa aqui significa que el tipo de viaje es un RT
            //            $DataArrayRetorno = "NULL";
            $data_vuelo['clase_retorno'] = "NULL";
            $data_vuelo['num_vuelo_retorno'] = "NULL";
            $data_vuelo['fechahora_salida_tramo_retorno'] = "NULL";
            $data_vuelo['fechahora_llegada_tramo_retorno'] = "NULL";
        } else {
            $DataArrayRetorno = explode('|', $grupo_retorno);
            $data_vuelo['clase_retorno'] = $DataArrayRetorno[1];
            $data_vuelo['num_vuelo_retorno'] = $DataArrayRetorno[2];
            $data_vuelo['fechahora_salida_tramo_retorno'] = $DataArrayRetorno[3];
            $data_vuelo['fechahora_llegada_tramo_retorno'] = $DataArrayRetorno[4];
        }
        return json_decode(json_encode($data_vuelo));
    }

    protected function GenerarTramaKiu_MetodoItineraryKiu($codigo_reserva)
    {
        $trama = array('CodReserva' => $codigo_reserva);
        return $trama;
    }

    private function EnviarTramakiuAirBook($trama)
    {
        $kiu = new Controller_kiu();
        $array_airbook = $kiu->AirBookRQ($trama, $err);
        $ResKiuXML = $array_airbook;
        return $ResKiuXML;
    }

    private function EnviarTramakiuAirItinerary($trama)
    {
        $kiu = new Controller_kiu();
        $array_airbook = $kiu->TravelItineraryReadRQ($trama, $err);
        return $array_airbook;
    }

    protected function RPH($xss_post)
    {
        //        return  $xss_post['cant_inf'];
        $p = 0;
        for ($i = 1; $i <= $xss_post['cant_inf']; $i++) {
            $nombres = trim($xss_post['nombres_adl_' . $i]);
            $apellidos = trim($xss_post['apellidos_adl_' . $i]);
            $tipo_documento = $xss_post['tipo_documento_adl_' . $i];
            $numero_documento = $xss_post['numdoc_adl_' . $i];
            $nacionalidad = $xss_post['nacionalidad_adl_' . $i];
            $tipo_pasajero = 'ADT';

            $arrayPersonasKiu[$p] = $this->FormarArrayPasajeros($nombres, $apellidos, $tipo_documento, $numero_documento, $nacionalidad, $tipo_pasajero, $xss_post['email']);

            $p++;

            $nombres = trim($xss_post['nombres_inf_' . $i]);
            $apellidos = trim($xss_post['apellidos_inf_' . $i]);
            $tipo_documento = $xss_post['tipo_documento_inf_' . $i];
            $numero_documento = $xss_post['numdoc_inf_' . $i];
            $nacionalidad = $xss_post['nacionalidad_inf_' . $i];
            $tipo_pasajero = 'INF';
            $arrayPersonasKiu[$p] = $this->FormarArrayPasajeros($nombres, $apellidos, $tipo_documento, $numero_documento, $nacionalidad, $tipo_pasajero, $xss_post['email']);
            $p++;
        }

        $c = ($p) / 2 + 1;

        for ($i = $c; $i <= $xss_post['cant_adl']; $i++) {
            $nombres = trim($xss_post['nombres_adl_' . $i]);
            $apellidos = trim($xss_post['apellidos_adl_' . $i]);
            $tipo_documento = $xss_post['tipo_documento_adl_' . $i];
            $numero_documento = $xss_post['numdoc_adl_' . $i];
            $nacionalidad = $xss_post['nacionalidad_adl_' . $i];
            $tipo_pasajero = 'ADT';
            $arrayPersonasKiu[$p] = $this->FormarArrayPasajeros($nombres, $apellidos, $tipo_documento, $numero_documento, $nacionalidad, $tipo_pasajero, $xss_post['email']);

            $p++;
        }

        /* CARGA DE DATOS DE PASAJEROS NI�OS */
        if ($xss_post['cant_chd'] > 0) {
            for ($j = 1; $j <= $xss_post['cant_chd']; $j++) {
                $nombres = trim($xss_post['nombres_chd_' . $j]);
                $apellidos = trim($xss_post['apellidos_chd_' . $j]);
                $tipo_documento = $xss_post['tipo_documento_chd_' . $j];
                $numero_documento = $xss_post['numdoc_chd_' . $j];
                $nacionalidad = $xss_post['nacionalidad_chd_' . $j];
                $tipo_pasajero = 'CNN';
                $arrayPersonasKiu[$p] = $this->FormarArrayPasajeros($nombres, $apellidos, $tipo_documento, $numero_documento, $nacionalidad, $tipo_pasajero, $xss_post['email']);
                $p++;
            }
        }
        return $arrayPersonasKiu;
    }

    protected function CalcularTiempoLimiteTicket($FechaHoraSalida)
    {

        $fecha_registro = date('Y-m-d H:i:s');
        $ticket_timelimit = '3';
        $fecha_limite = SumarRestarHoras('+', $fecha_registro, 3);
        $fecha_presentar = SumarRestarHoras('-', $FechaHoraSalida, 2);
        $tiempo_diferencia = 180;
        $hora_inicial = explode(" ", $fecha_registro);
        $hora_fin = explode(" ", $fecha_presentar);

        if (strtotime($hora_inicial[0]) == strtotime($hora_fin[0])) { /* FECHA DE REGISTRO IGUAL A FECHA DE SALIDA */

            if (strtotime($fecha_limite) > strtotime($fecha_presentar)) { /* HORA LIMITE DE PAGO MAYOR A HORA DE PRESENTACION */

                $partes1 = explode(":", $hora_inicial[1]);
                $partes2 = explode(":", $hora_fin[1]);

                $dif_hora = $partes2[0] - $partes1[0];
                if ($partes2[1] >= $partes1[1]) {
                    $dif_min = $partes2[1] - $partes1[1];
                } else {
                    $dif_hora--;
                    $dif_min = ($partes2[1] + 60) - $partes1[1];
                }

                if ($dif_min != 0) {
                    $tiempo_diferencia = $dif_hora * 60 + $dif_min;
                } else {
                    $tiempo_diferencia = $dif_hora * 60;
                }

                if ($tiempo_diferencia <= 60) {
                    $ticket_timelimit = '1';
                    $fecha_limite = SumarRestarHoras('+', $fecha_limite, 1);
                    $expira = $ticket_timelimit * 60;
                } elseif ($tiempo_diferencia <= 120) {
                    $ticket_timelimit = '2';
                    $fecha_limite = SumarRestarHoras('+', $fecha_limite, 2);
                    $expira = $ticket_timelimit * 60;
                }
            }
        }
        return $ticket_timelimit;
    }

    protected function FormarArrayPasajeros($nombres, $apellidos, $tipo_documento, $numero_documento, $nacionalidad, $tipo_pasajero, $email)
    {
        return array(
            'Nombres' => strtoupper(sanear_string(($nombres))),
            'Apellidos' => strtoupper(sanear_string(($apellidos))),
            'Tipo_Documento' => $tipo_documento,
            'Numero_Documento' => strtoupper($numero_documento),
            'Nacionalidad' => $nacionalidad,
            'Tipo_Pasajero' => $tipo_pasajero,
            'Email' => utf8_encode(strtoupper($email))
        );
    }

    protected function GenerarTramaKiu_MetodoAirBookKiu($itinerario, $matriz_pax, $xss_post, $TimeLimitTicket)
    {

        $trama = array(
            'TicketDesignatorCode'=>$xss_post['cod_descuento'] ,'City' => 'LIM', 'Country' => 'PE', 'Currency' => 'USD', 'FlightSegment' => $itinerario, 'Passengers' => $matriz_pax, 'Telefono' => $xss_post['num_tlfn'], 'CodigoAreaTel' => 'D1' . ddi_solonumero($xss_post['ddi_pais_tlfn']) . 'P1' . trim($xss_post['region_tlfn']), 'Celular' => $xss_post['num_cel'], 'CodigoAreaCel' => 'D2' . ddi_solonumero($xss_post['ddi_pais_cel']) . 'P2' . trim($xss_post['region_cel']), 'Remark' => $xss_post['ruc'], 'TiempoExpiracionReserva' => $TimeLimitTicket
        );
        return $trama;
    }

    public function ReprocesarTransaccion()
    {

        $xss_post = $this->input->post(NULL, TRUE);
        //        $total_pagar = $xss_post['total_pagar'];
        //        $pnr = $xss_post['pnr'];
        // $reserva_id = $xss_post['reserva_id'];
        $reserva_id = 1782925;
        $cc_code = $xss_post['cc_code'];
        $campos = 'num_celular,pnr,total_pagar,fecha_limite,email,ruc,nombres,apellidos,nacionalidad,tipo_documento,num_documento';
        $res_datareserva = $this->Reserva_model->BuscarReservaPorId($reserva_id, $campos);
        $codigo_pais = $this->Pais_model->GetCodigoPaisPaisPorId($res_datareserva->nacionalidad);

        $data_reprocesa['fecha_limite'] = $res_datareserva->fecha_limite;
        $data_reprocesa['cc_code'] = $xss_post['cc_code'];
        $data_reprocesa['num_cel'] = $res_datareserva->num_celular;
        $data_reprocesa['email'] = $res_datareserva->email;
        $data_reprocesa['nombres_adl_1'] = $res_datareserva->nombres;
        $data_reprocesa['apellidos_adl_1'] = $res_datareserva->apellidos;
        $data_reprocesa['ddi_pais_cel'] = $codigo_pais;
        $data_reprocesa['tipo_documento_adl_1'] = $res_datareserva->tipo_documento;
        $data_reprocesa['numdoc_adl_1'] = $res_datareserva->num_documento;
        $data_reprocesa['ruc'] = (empty($res_datareserva->ruc) || $res_datareserva->ruc === "NULL") ? '' : $res_datareserva->ruc;
        
        $this->Reserva_model->ActualizarMetodoPagoTransaccion($cc_code, $reserva_id);

        $this->PosicionarMetodoDePago($data_reprocesa, $res_datareserva->total_pagar, $res_datareserva->pnr, $reserva_id);
    }

}
