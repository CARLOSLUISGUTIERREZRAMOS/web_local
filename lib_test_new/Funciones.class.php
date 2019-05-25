<?php
class Funciones{
	private $cadcon;
	private $cn;

	function __construct(){
		$this->cadcon 	= ConexionBD::CadenaCN();
		$this->cn       = AccesoBD::ConexionBD($this->cadcon);
    }

	public function traduccion($archivo,$texto,$idioma){
		
		mysql_query('SET NAMES \'utf8\'');
		
		$sql = "select * from idioma where codigo = '$idioma'";
		
		$lista = AccesoBD::Consultar($this->cn,$sql);
		$campo = $lista[0];
		$id_idioma = $campo["id_idioma"];

		$sql = "select * from traduccion where archivo = '$archivo' and texto = '$texto' ";
		$lista = AccesoBD::Consultar($this->cn,$sql);
		$campo = $lista[0];

		$nTraduccion = count($lista);
		if ($nTraduccion ){
			$campo2 = "idioma$id_idioma";
			$traduccion = $campo[$campo2];
		}else{
			$traduccion = "";
		}
		return $traduccion;
	}

	public function parametro($param){
		$sql = "select * from parametro where parametro= '$param'";
		$lista = AccesoBD::Consultar($this->cn,$sql);
		$campo = $lista[0];
		return $campo["valor"];
	}

	public function buscar($id_reserva){
		$sql = "select * from reserva where id_reserva= $id_reserva";
		$lista = AccesoBD::Consultar($this->cn,$sql);
		$campo = $lista[0];
		return $campo;
	}


	public function buscarCiudad($id_ciudad){
		$sql = "select * from ciudad where id_ciudad='".$id_ciudad."'";
		$lista = AccesoBD::Consultar($this->cn,$sql);
		$campo = $lista[0]["ciudad"];
		return $campo;
	}

	
	
	public function buscar_all($id_reserva){
		$sql = "select * from reserva where id_reserva= $id_reserva";
		$lista = AccesoBD::Consultar($this->cn,$sql);
		$campo = $lista[0];
		return $campo;
	}


	public function buscar_all_pasajeros($id_reserva){
		
		$sql = "SELECT * FROM reserva_detalle WHERE id_reserva= $id_reserva";
		//echo $sql . "<br>";
		$lista = AccesoBD::Consultar($this->cn,$sql);
		return $lista;
	}


	public function buscar_all_pnr($cod_reserva){
		$sql = "select * from reserva where id_reserva= $id_reserva";
		$lista = AccesoBD::Consultar($this->cn,$sql);
		$campo = $lista;
		return $campo;
	}

	public function actualiza_ticket_reserva($id_reserva, $campoTicket,$valorTicket){
		$sql = "update reserva set $campoTicket='$valorTicket' where id_reserva = $id_reserva";
		$rpta=AccesoBD::OtroSQL($this->cn,$sql);
		return $rpta;
	}

	public function actualiza_ticket_detallereserva($id_detalle, $valorTicket){
		$sql 	= "update reserva_detalle set num_ticket = '$valorTicket' where id_reserva_detalle = $id_detalle";
		$rpta=AccesoBD::OtroSQL($this->cn,$sql);
		return $rpta;
	}


	public function actualiza_operacion_mc($arrayRespuestaMC){
		$sql = "
		update reserva set 
		cc_code = '".$arrayRespuestaMC["cc_code"]."', 
		cc_number='".$arrayRespuestaMC["cc_number"]."', 
		cc_auth = '".$arrayRespuestaMC["cc_auth"]."', 
		cc_exp='".$arrayRespuestaMC["cc_exp"]."', 
		cod_tienda = '".$arrayRespuestaMC["cod_tienda"]."', 
		mc_resultado = '".$arrayRespuestaMC["mc_resultado"]."', 
		mc_cod_aut = '".$arrayRespuestaMC["mc_cod_aut"]."', 
		mc_num_ref='".$arrayRespuestaMC["mc_num_ref"]."', 
		mc_cod_rpta='".$arrayRespuestaMC["mc_cod_rpta"]."', 
		mc_cod_pais='".$arrayRespuestaMC["mc_cod_pais"]."', 
		mc_BIN = '".$arrayRespuestaMC["mc_BIN"]."', 
		mc_cod_seg='".$arrayRespuestaMC["mc_cod_seg"]."', 
		cc_noaut = '".$arrayRespuestaMC["cc_noaut"]."', 
		cc_total = ".$arrayRespuestaMC["cc_total"].", 
		total_pagar= ".$arrayRespuestaMC["total_pagar"].", 
		fecha_trans='".$arrayRespuestaMC["fecha_trans"]."', 
		validacion = '".$arrayRespuestaMC["validacion"]."' 
		where id_reserva=".$arrayRespuestaMC["id_reserva"];
		
		$rpta=AccesoBD::OtroSQL($this->cn,$sql);
		return $rpta;
	}



	public function confirmacion_sp($id_reserva){
		$sql = "update reserva set cc_code = 'SP' where id_reserva = $id_reserva";
		$conf = AccesoBD::OtroSQL($this->cn,$sql);
		return $conf;
	}

	public function confirmacion_sp_pagar($id_reserva,$sql){
		$sql = "update reserva set cc_code = 'SP', $sql  where id_reserva = $id_reserva";
		$conf = AccesoBD::OtroSQL($this->cn,$sql);
		return $conf;
	}



/***********************************************************************************************/
	public function listaCiudadesOrigen(){
		$sql = "SELECT DISTINCT c.*  FROM ciudad c, ruta r WHERE c.codigo=r.ciudad_origen_codigo AND r.estado=1 AND c.estado=1 ORDER BY nombre asc ";
		//echo $sql . "<br>";
		$conf = AccesoBD::Consultar($this->cn,$sql);
		return $conf;
		//return $sql;
	}
/***********************************************************************************************/        
        
        
/***********************************************************************************************/	
	public function listaCiudadesDestino($origen){
		$sql = "SELECT DISTINCT c.codigo AS hasta, c.nombre FROM ciudad c, ruta r WHERE c.codigo=r.ciudad_destino_codigo AND r.ciudad_origen_codigo='$origen' AND r.estado=1 AND c.estado=1 order by c.nombre asc" ;
//		$sql = "SELECT DISTINCT c.codigo AS hasta, c.ciudad FROM ciudad c, ruta r WHERE c.codigo=r.ciudad_destino_codigo AND r.ciudad_origen_codigo='$origen' AND r.estado=1 AND c.estado=1  order by c.nombre asc" ;
		//echo $sql . "<br>";
		$conf = AccesoBD::Consultar($this->cn,$sql);
		return $conf;
//		return $sql;
	}
/***********************************************************************************************/




	public function fn_myip(){
		return $_SERVER["REMOTE_ADDR"];
	}

	public function busca_limit_sp($idReserva) 
	{
		$sql="select * from reserva where id_reserva=$idReserva";
		$lista = AccesoBD::Consultar($this->cn,$sql);

		$n = count($lista);
		if($n>0)
		{
			$fechaAuxIni=$lista["vuelo_fecha_depart"];
			$horaVueloIni=$lista["vuelo_hora_depart"];
			$fechaCompraSist=$lista["fechareg"];
					
			$fechaCompraSistArray=split(" ",$fechaCompraSist);
			$diaCompra=$fechaCompraSistArray[0];
			$horaCompra=$fechaCompraSistArray[1];
			
			$diaCompraArray=split("-",$diaCompra);
			$horaCompraArray=split(":",$horaCompra);		
					
			$diaVuelo=substr($fechaAuxIni,0,2);
			$mesVuelo= $this->verMesNro(trim(substr($fechaAuxIni,2,5)));
			$annoVuelo=date("Y");
			
			if($mesVuelo<date("m")) $annoVuelo=date("Y")+1;
			
			$horaVuelo=substr($horaVueloIni,0,2);
			$minutoVuelo=substr($horaVueloIni,2,4);
			
			$fechaCompra = mktime($horaCompraArray[0],$horaCompraArray[1],0,$diaCompraArray[1],$diaCompraArray[2],$diaCompraArray[0]); 
			$fechaVueloDestino = mktime($horaVuelo,$minutoVuelo,0,$mesVuelo,$diaVuelo,$annoVuelo); 
	
			$diferencia = $fechaVueloDestino-$fechaCompra; 
			$horasDiferencia = (int)($diferencia/(60*60)); 
	
			if($horasDiferencia>=9) $valorFuncion=6;		
			elseif($horasDiferencia==8) $valorFuncion=5;
			elseif($horasDiferencia==7) $valorFuncion=4;
			elseif($horasDiferencia==6) $valorFuncion=3;
			elseif($horasDiferencia==5) $valorFuncion=2;
			elseif($horasDiferencia==4) $valorFuncion=1;
			elseif($horasDiferencia>=1 && $horasDiferencia<=3) $valorFuncion=1;
			else $valorFuncion=1;
		}
		return $valorFuncion;
	}

	public function verMesNro($mes) 
	{
		$month = array( 'JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);
		return $month[$mes];
	}

	public function verMesPago($mes,$idioma) 
	{
		$month = array( 'JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);	
		$valorMes=$month[$mes];
		$ames_sp= array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
		$ames_en= array("", "January","February","March","April","May","June","July","August","September","October","November","December");
		$ames_fr= array("", "Janvier","F&eacute;vrier","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","D&eacute;cembre");
	
		if($idioma=='es') return $ames_sp[$valorMes];
		elseif($idioma=='fr') return $ames_fr[$valorMes];
		else return $ames_en[$valorMes];	
		
	}


	public function verDiaSemanaDisponibilidad($fecha,$diasSuma,$idioma) 
	{
		$ames_sp= array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
		$ames_en= array("", "January","February","March","April","May","June","July","August","September","October","November","December");
		$ames_fr= array("", "Janvier","F&eacute;vrier","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","D&eacute;cembre");
		$month = array( 'JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);	
		
		list($ano, $mes, $dia)=explode("-",$fecha);
		$auxFechaSalida=date("d:M", mktime(0, 0, 0, $mes, $dia + $diasSuma, $ano));
		
		list($diaReturn, $mesMuestra)=explode(":",$auxFechaSalida);

		$mesMuestra=strtoupper($mesMuestra);
		$valorMes=$month[$mesMuestra];

		if( strtoupper($idioma)==strtoupper('SP') ) $mesMuestra=$ames_sp[$valorMes];
		elseif( strtoupper($idioma)==strtoupper('FR')) $mesMuestra=$ames_fr[$valorMes];
		else $mesMuestra=$ames_en[$valorMes];	
		
		return $diaReturn . " " . $mesMuestra;
	}

        public function GuardaPasajeroWeb($nombre, $apellido, $email){
                $sql = "INSERT INTO newsletter (nombre, apellido, mail) VALUES ('$nombre','$apellido','$email')";
		//echo $sql . "<br>";
		$conf = AccesoBD::Insertar($this->cn,$sql);
		return $conf;
        }



}





?>