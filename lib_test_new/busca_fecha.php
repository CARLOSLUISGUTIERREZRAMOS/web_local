<?php
date_default_timezone_set('America/Lima');
$manana=date("d/m/Y",time());
$dias_dis=date("d/m/Y",time()+(2*24*60*60));

echo $manana . "<>" . $dias_dis ;
?>