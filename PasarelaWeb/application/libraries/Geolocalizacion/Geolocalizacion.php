<?php

class Geolocalizacion {

    var $gmt_timezone = 'America/Lima';
    var $timezones = array(
        '-12' => 'UM12',
        '-11' => 'UM11',
        '-10' => 'UM10',
        '-9' => 'UM9',
        '-8' => 'UM8',
        '-7' => 'UM7',
        '-6' => 'UM6',
        '-5' => 'UM5',
        '-4' => 'UM4',
        '-3.5' => 'UM25',
        '-3' => 'UM3',
        '-2' => 'UM2',
        '-1' => 'UM1',
        '0' => 'UTC',
        '1' => 'UP1',
        '2' => 'UP2',
        '3.5' => 'UP25',
        '3' => 'UP3',
        '4.5' => 'UP35',
        '4' => 'UP4',
        '4.5' => 'UP45',
        '5' => 'UP5',
        '6' => 'UP6',
        '7' => 'UP7',
        '8' => 'UP8',
        '9.5' => 'UP85',
        '9' => 'UP9',
        '10' => 'UP10',
        '11' => 'UP11',
        '12' => 'UP11',
    );

    function __construct() {
        include_once("geoipcity.inc");
        include_once("geoipregionvars.php");
    }

  
    function geo_ciudad_pais($ip) {
        
        $gi = geoip_open(dirname(__FILE__)."/GeoLiteCity.dat", GEOIP_STANDARD);
        $record = geoip_record_by_addr($gi, $ip);
//        var_dump($record);
        geoip_close($gi);
        $ciudad=$record->city.' , '.$record->country_code;
        $pais= $record->country_code;
        return $ciudad.'|||'.$pais;
    }

  

}
