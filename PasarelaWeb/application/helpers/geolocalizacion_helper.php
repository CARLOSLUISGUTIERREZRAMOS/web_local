<?php

if (!function_exists('GetDatosGeolocalizacion')) {

    function GetDatosGeolocalizacion()
    {
        $CI = &get_instance();
        $CI->load->library('Geolocalizacion/Geolocalizacion');
        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = '35.238.63.231';
        $geo = new Geolocalizacion();
        $res_ip = $geo->geo_ciudad_pais($ip);
        $arrayGeo = explode('|||', $res_ip);
        $pais_ciudad['PAIS'] = strtoupper(trim($arrayGeo[1]));
        $ciudadPais = trim($arrayGeo[0]);
        $splitCiudad = explode(',', $ciudadPais);
        $pais_ciudad['CIUDAD'] = strtoupper(trim($splitCiudad[0]));
        return $pais_ciudad;
    }
    
}

