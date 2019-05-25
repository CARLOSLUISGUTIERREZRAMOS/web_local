<?php
class AccesoBD{
	public static function ConexionBD($CadenaConexion){
		try{
			$cn = mysqli_connect($CadenaConexion["servidor"], $CadenaConexion["usuario"], $CadenaConexion["password"],$CadenaConexion["basedatos"]);
			if(mysqli_error($cn)){
				throw new Exception(mysqli_error($cn));
			}
			return $cn;
		}catch(Exception $e){
			error_log($e->getMessage(),3,"error.log");
		}
	}

	public static function ConexionKiu(){
        try{
			$sql = "select * from parametro where parametro = 'kiu_server'";
			$rsParam = mysqli_query($sql);
			$arreglo['server'] = mysql_result($rsParam,0,"valor");

			$sql = "select * from parametro where parametro = 'kiu_user'";
			$rsParam = mysqli_query($sql);
			$arreglo['user'] = mysql_result($rsParam,0,"valor");

			$sql = "select * from parametro where parametro = 'kiu_pass'";
			$rsParam = mysqli_query($sql);
			$arreglo['password'] = mysqli_result($rsParam,0,"valor");

			return $arreglo;
        }catch(Exception $e){
			error_log($e->getMessage(),3,"error.log");
        }
	}

	public static function InsertarLog($accion,$pnr,$apellido,$cc_code, $parametro, $error, $mensaje){
        try{
			$fecha_hora = date('Y-m-d H:i:s');
    		$sql = " insert into pasarela_log (accion,pnr,apellido,cc_code,parametro, error,mensaje,fecha_hora) 
						values ('$accion','$pnr','$apellido','$cc_code', '$parametro', '$error', '$mensaje','$fecha_hora')";
			mysqli_query($sql);
			if(mysqli_error($cn)){
				throw new Exception( mysqli_error($cn) );
            }
        }catch(Exception $e){
			error_log($e->getMessage(),3,"error.log");
        }
	}


	public static function Consultar($idConexion,$ComandoSelect){
        try{
	      $rs = mysqli_query($idConexion,$ComandoSelect);
	      if(mysqli_error($idConexion)){
				throw new Exception( mysqli_error($idConexion) );
               }
              $arreglo=array();
               while($fila = mysqli_fetch_assoc($rs)){
            	$arreglo[] = $fila;
               }
	      return $arreglo;
              
            }catch(Exception $e){
			error_log($e->getMessage(),3,"error.log");
           }
	}

	public static function Contar($idConexion,$ComandoSelect){
        try{
                 $rs = @mysqli_query($ComandoSelect,$idConexion);
                 if(mysqli_error($idConexion)){
                         throw new Exception( mysqli_error($idConexion) );
                 }
                 $valor = @mysqli_result($rs,0,0);
                 if(mysqli_error($idConexion)){
                         throw new Exception( mysqli_error($idConexion) );
                 }
                 return $valor;
        }catch(Exception $e){
                 error_log($e->getMessage(),3,"error.log");
        }
	}
        
	public static function Insertar($idConexion,$ComandoInsert){
           try{
                    @mysqli_query($ComandoInsert,$idConexion);
                    if(mysqli_error($idConexion)){
                            throw new Exception( mysqli_error($idConexion) );
                    }
                    $valor = mysqli_insert_id($idConexion);
                    return $valor;
           }catch(Exception $e){
                    error_log($e->getMessage(),3,"error.log");
           }
   }
   
	public static function OtroSQL($idConexion,$ComandoSQL){
           try{
				    //echo $ComandoSQL . "<br>";
                    $rpta = @mysqli_query($ComandoSQL,$idConexion);
                    if(mysqli_error($idConexion)){
                            throw new Exception(mysqli_error($idConexion));
                    }
					return $rpta;
           }catch(Exception $e){
                    error_log($e->getMessage(),3,"error.log");
           }
   }
}
?>
