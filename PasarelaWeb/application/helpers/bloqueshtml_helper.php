<?php

if (!function_exists('ArmarBloqueCodigoDescuento')) {

    function ArmarBloqueCodigoDescuento($cc_codes_validos)
    {
        $CI = &get_instance();
        $data['cc_codes'] = $cc_codes_validos;
        $html_codigo_descuento = $CI->load->view('codigo_descuento/v_codigo_descuento', $data, TRUE);
        return $html_codigo_descuento;
        
    }
}

if (!function_exists('ArmarBloqueInfoReservaConCodDesc')) {

    function ArmarBloqueInfoReservaConCodDesc()
    {
        $CI = &get_instance();
        $html_codigo_descuento = $CI->load->view('codigo_descuento/v_info_pnr_con_desc');
        return $html_codigo_descuento;
        
    }
}
