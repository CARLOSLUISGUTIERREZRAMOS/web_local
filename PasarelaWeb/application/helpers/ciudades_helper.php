<?php

if (!function_exists('ObtenerNombreCiudad')) {

    function ObtenerNombreCiudad($cod_ciudad) {
        $nombre_ciudad = '';
        switch ($cod_ciudad){
            case  'LIM':
                $nombre_ciudad = 'Lima';
                break;
            case  'CUZ':
                $nombre_ciudad = 'Cusco';
                break;
            case  'IQT':
                $nombre_ciudad = 'Iquitos';
                break;
            case  'PCL':
                $nombre_ciudad = 'Pucallpa';
                break;
            case  'PEM':
                $nombre_ciudad = 'Puerto Maldonado';
                break;
            case  'TPP':
                $nombre_ciudad = 'Tarapoto';
                break;
            case  'CJA':
                $nombre_ciudad = 'Cajamarca';
                break;
            case  'CIX':
                $nombre_ciudad = 'Chiclayo';
                break;
            default : $nombre_ciudad ='Nombre Ciudad sin definir';
        }
        return $nombre_ciudad;
        
    }

}