<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();

//        $this->config->set_item('language', 'spanish');

        $this->load->model('Ciudad_model');
        $this->load->model('Ruta_model');
        $this->load->library('kiu/Controller_kiu');
        
    }

    public function index() {
        
        $this->session->unset_userdata('pnr');
        $this->session->unset_userdata('apellidos');
//        $iseet =  $this->session->has_userdata('pnr');
//        var_dump($iseet);
        $this->template->add_js('js/bootstrap.min.js');
        $this->template->carga_pagina('INICIO');
        $data['ciudad_origen'] = $this->GenerarCiudadOrigen();
        $this->template->load_main('v_main');
    }

    public function GenerarCiudadOrigen() {
        $campos = 'codigo,nombre';
        $condicion = array('estado' => '1');
        $res_model = $this->Ciudad_model->GetCiudad($campos, $condicion);
        return $res_model;
    }

    public function ObtenerRutas() {

        $ciudad_origen_codigo = $_POST['ciudad_origen'];
        $ciudad_condicion = array('ciudad_origen_codigo' => $ciudad_origen_codigo, 'ruta.estado' => 1);
        $ciudades_destino = $this->Ruta_model->GetRutas($ciudad_condicion);
        echo json_encode($ciudades_destino->result_array());
    }

    function Iquitos() {
        $this->template->carga_pagina('IQT');
        $url = 'html/es/iquitos';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function cajamarca() {
        $this->template->carga_pagina('CJA');
        $url = 'html/es/iquitos';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function chiclayo() {
        $this->template->carga_pagina('CIX');
        $url = 'html/es/iquitos';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function Cusco() {
        $this->template->carga_pagina('CUZ');
        $url = 'html/es/iquitos';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function Tarapoto() {
        $this->template->carga_pagina('TPP');
        $url = 'html/es/tarapoto';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function Destinos() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('DESTINOS');
        $url = 'html/es/destinos';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function Promociones() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('PROMOCIONES');
        $url = 'html/es/promociones';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function ServiciosEspeciales() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('SERVICIOS_ESPECIALES');
        $url = 'html/es/servicios-especiales';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function Servicios_al_cliente() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('SERVICIOS_AL_CLIENTE');
        $url = 'html/es/servicio-al-cliente';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function viajes_grupales() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('VIAJES_GRUPALES');
        $url = 'html/es/viajes-grupales';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function oficinas() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('OFICINAS');
        $url = 'html/es/oficinas';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function sobre_mi_equipaje() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('SOBRE_MI_EQUIPAJE');
        $url = 'html/es/sobre-mi-equipaje';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function starperu_cargo() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('CARGO');
        $url = 'html/es/starperu-cargo';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function flota() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('FLOTA');
        $url = 'html/es/flota';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function la_empresa() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('LA_EMPRESA');
        $url = 'html/es/la-empresa';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function contacto() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('CONTACTO');
        $url = 'html/es/contacto';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function contrato_de_transporte() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('CONTRATO_TRANSPORTE');
        $url = 'html/es/contrato-de-transporte';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function condiciones_de_venta() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('CONDICIONES_DE_VENTA');
        $url = 'html/es/condiciones-de-venta';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function condiciones_clases_tarifarias() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('CLASES_TARIFARIAS');
        $url = 'html/es/condiciones-de-clases-tarifarias';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function endosos_y_postergaciones() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('ENDOSOS_POSTERGACIONES');
        $url = 'html/es/endosos-y-postergaciones';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function preguntas_frecuentes() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('PREGUNTAS_FRECUENTES');
        $url = 'html/es/preguntas-frecuentes';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function privacidad() {
        $this->template->muestra_calendario(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('PRIVACIDAD');
        $url = 'html/es/preguntas-frecuentes';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

    function mapa_del_sitio() {

        $this->template->muestra_calendario(FALSE);
        $this->template->muestra_carousel(FALSE);
        $this->template->setea_body('internas');
        $this->template->carga_pagina('MAPA_DEL_SITIO');
        $url = 'html/es/mapa-del-sitio';
        $this->template->set_url_html($url);
        $this->template->load_main($url);
    }

}
