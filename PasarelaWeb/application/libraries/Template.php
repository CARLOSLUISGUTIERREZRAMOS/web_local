<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    var $styles = "";
    var $scripts = "";
    var $scripts_a = "";
    var $template_data = array();
    var $template_layout = 'templates/layout';
    var $template_layout_main = 'templates/layout_main';
    var $page = "";
    var $muestra_calendario = TRUE;
    var $muestra_carousel = TRUE;
    var $class_body = 'inicio reservas-on';
    var $url;

//    
    function set($name, $value) {
        $this->template_data[$name] = $value;
    }
    function set_url_html($url) {
        $this->url = $url;
    }

    function add_css($pathfile) {
        $this->styles .= link_tag($pathfile);
    }
    function carga_pagina($argumento) {
        $this->page = $argumento;
    }
    function muestra_calendario($argumento_bool) {
        $this->muestra_calendario= $argumento_bool;
    }
    function muestra_carousel($argumento_bool) {
        $this->muestra_carousel= $argumento_bool;
    }
    function setea_body($class_body) {
        $this->class_body= $class_body;
    }

    function add_js($pathfile) {
        $this->scripts .= script_tag($pathfile);
    }
    function add_js_analitics($pathfile) {
        $this->scripts_a .= script_tag($pathfile);
    }

    function load($view = '', $view_data = array(), $return = FALSE) {

        $this->CI = &get_instance();
        $model = &get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->template_data['styles'] = $this->styles;
        $this->template_data['scripts'] = $this->scripts;
        $this->template_data['scripts_analitics'] = $this->scripts_a;
        return $this->CI->load->view($this->template_layout, $this->template_data, $return);
    }

    function load_main($view = '', $view_data = array(), $return = FALSE) {

        $this->CI = &get_instance();
        $model = &get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->template_data['styles'] = $this->styles;
        $this->template_data['scripts'] = $this->scripts;
        $this->template_data['CARGA_PAGINA'] = $this->page;
        $this->template_data['MUESTRA_CAROUSEL'] = $this->muestra_carousel;
        $this->template_data['class_body'] = $this->class_body;
        $this->template_data['url'] = $this->url;
        $this->template_data['MUESTRA_CALENDARIO'] = $this->muestra_calendario;
        return $this->CI->load->view($this->template_layout_main, $this->template_data, $return);
    }

    function load_header() {
        return $this->CI->load->view("templates/header");
    }
    function load_header_main($muestra_menu) {
        $data['muestra_menu'] = $muestra_menu;
        return $this->CI->load->view("templates/header_main",$data);
    }

    function load_calendar() {
        $model = &get_instance();
        $model->load->model("adm/Ciudad_model");
        $campos = 'codigo,nombre';
        $condicion = array('estado' => '1');
        $data['ciudad_origen']= $model->Ciudad_model->GetCiudad($campos, $condicion);
        
        return $this->CI->load->view("bloques_main/v_container_reserva",$data);
    }

    function load_footer() {
        return $this->CI->load->view("templates/footer");
    }

}

?>