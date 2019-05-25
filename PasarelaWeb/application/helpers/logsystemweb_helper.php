<?php

function dispara_log($id_reserva,$metodo_pago,$metodo_servicio,$cadena,$tipo_solicitud)
{
    	$arch = fopen(realpath( '.' )."/logs/log_web_".$metodo_pago."_".date("Y-m-d").".txt", "a+"); 

	fwrite($arch, "[".date("Y-m-d H:i:s.u")." "
                .$_SERVER['REMOTE_ADDR']." "
                . "- $id_reserva ] [METODO: $metodo_servicio - SOLICITUD: $tipo_solicitud] ".$cadena."\n");
	fclose($arch);
}

function dispara_log_kiu($id_reserva,$metodo_servicio,$rq,$rs)
{
    	$arch = fopen(realpath( '.' )."/logs/log_web_kiu_".date("Y-m-d").".txt", "a+"); 

	fwrite($arch, "[".date("Y-m-d H:i:s.u")." "
                .$_SERVER['REMOTE_ADDR']." "
                . "- $id_reserva ] [METODO: $metodo_servicio] "."\n".$rq."\n".$rs."\n");
	fclose($arch);
}