<?php
require_once("ConexionBD.class.php");
require_once("AccesoBD.class.php");
require_once("Funciones.class.php");

$objFun= new Funciones();
$listaDestino=$objFun->listaCiudadesOrigen();
$textoCombo='';
for($i=0;$i<count($listaDestino);$i=$i+1){
	$textoCombo=$textoCombo . $listaDestino[$i]["codigo"].':'.$listaDestino[$i]["nombre"].'>';
}
 
echo $textoCombo; 

?>