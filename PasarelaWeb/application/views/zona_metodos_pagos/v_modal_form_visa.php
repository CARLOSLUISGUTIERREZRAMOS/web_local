<?php
$attributes = array('id' => 'form_visa', "style" => "display: none");
echo form_open("ZonaPagos/ApiVisaNet", $attributes);
?>
<script src='<?= $libreriaJsVisa ?>'
        data-sessiontoken='<?= $session_key ?>'
        data-channel='web'
        data-merchantid='<?= $codigo_comercio ?>'
        data-merchantlogo= '<?= base_url() ?>img/logotipostarvisa.png'
        data-formbuttoncolor='#D80000'
        data-purchasenumber=<?= $id_reserva ?>
        data-amount=<?= $TOTALPAGAR ?>
        data-expirationminutes= 5
        data-timeouturl = '<?= base_url() ?>html/visa/tiempo_limite.html'
></script>
<?= form_close() ?>