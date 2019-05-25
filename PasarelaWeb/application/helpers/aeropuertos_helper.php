<?php

if (!function_exists('ObtenerNombreAeropuerto')) {

    function ObtenerNombreAeropuerto($cod_ciudad) {
        $nombre_aeropuerto = '';
        switch ($cod_ciudad){
            case  'LIM':
                $nombre_aeropuerto = 'Internacional Jorge Chávez';
                break;
            case  'CUZ':
                $nombre_aeropuerto = 'Alejandro Velazco Astete';
                break;
            case  'IQT':
                $nombre_aeropuerto = 'Coronel FAP Francisco Secada V.';
                break;
            case  'PCL':
                $nombre_aeropuerto = 'Internacional Capitán FAP David Abensur Rengifo ';
                break;
            case  'PEM':
                $nombre_aeropuerto = 'Padre Aldamiz';
                break;
            case  'TPP':
                $nombre_aeropuerto = 'Cadete FAP Guillermo del Castillo Paredes';
                break;
            case  'CJA':
                $nombre_aeropuerto = 'Mayor Gral. FAP Armando Revoredo';
                break;
            case  'CIX':
                $nombre_aeropuerto = 'Capitán FAP José Quiñones G.';
                break;
            default : $nombre_aeropuerto ='Nombre Aeropuerto sin definir';
        }
        return $nombre_aeropuerto;
        
    }

}