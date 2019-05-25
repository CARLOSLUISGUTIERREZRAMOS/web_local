<?php

require_once("ConexionBD.class.php");
require_once("AccesoBD.class.php");
require_once("Funciones.class.php");

$objFun= new Funciones();
//$nombre = $_GET['nombre'];
//$apellido = $_GET['apellido'];
//$email = $_GET['email'];
$guarda_pax=$objFun->GuardaPasajeroWeb($_REQUEST['nombre'], $_REQUEST['apellido'], $_REQUEST['email']);

return $guarda_pax; 

