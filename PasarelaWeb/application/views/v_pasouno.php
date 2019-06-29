<div class="container">
    <?= form_open('Booking2') ?>
    <div class="row">
        <div class="col-12" id="Tarifas">
            <div class="accordion" id="accordionStar2">
                <?php
                if ($tipo_viaje === "O") {
                    $this->load->view('bloques_pasouno/v_bloque_ida', $data_ida);
                } else if ($tipo_viaje === "R") {
                    $this->load->view('bloques_pasouno/v_bloque_ida', $data_ida);
                    $this->load->view('bloques_pasouno/v_bloque_retorno', $data_retorno);
                }
                ?>
            </div>
        </div>
        <div class="col-12">
            <hr>
        </div>

        <div class="col-12">
            <div class="card final-price">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-6">
                        <h1 id="PrecioTotal">
                            <b><small>$ <span id="precio_total">00.00</span> USD</small></b>
                        </h1>
                        <h5>Tarifa Neta</h5>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <input type="hidden" name="cod_origen" value="<?= $data_ida['origen'] ?>">
                        <input type="hidden" name="cod_destino" value="<?= $data_ida['destino'] ?>">
                        <input type="hidden" name="geoip_pais" value="<?= $geoip_pais ?>">
                        <input type="hidden" name="geoip_ciudad" value="<?= $geoip_ciudad ?>">
                        <input type="hidden" name="fecha_ida" value="<?= fecha_iso_8601($date_from) ?>">
                        <input type="hidden" name="fecha_retorno" value="<?= fecha_iso_8601($date_to) ?>">
                        <input type="hidden" id="tipo_viaje" name="tipo_viaje" value="<?= $tipo_viaje ?>">
                        <input type="hidden" name="cant_adl" value="<?= $cant_adultos ?>">
                        <input type="hidden" name="cant_chd" value="<?= $cant_ninos ?>">
                        <input type="hidden" name="cant_inf" value="<?= $cant_infantes ?>">
                        <p class="text-right">
                            <button type="submit" id="validate" class="btn btn-primary btn-lg">Continuar</button>
                        </p>
                    </div>
                    <div class="col-12">
                        <div class="accordion" id="accordionTerms">
                            <div class="card">
                                <div class="card-header" id="headingOneTerms">
                                    <a class="accordion-toggle collapsed" href="#collapseTerms" data-toggle="collapse" data-parent="#collapseTwo" aria-expanded="true" aria-controls="collapseTerms">
                                        <h5>Términos y condiciones:</h5>
                                    </a>
                                </div>
                                <div id="collapseTerms" class="collapse" aria-labelledby="headingOneTerms" data-parent="#accordionTerms">
                                    <div class="card-body">

                                        <br> <label id="titulo_ida"></label> <br>

                                        <label id="alex"></label>   


                                        <br> <label id="titulo_vuelta"></label> <br>
                                        <label id="alex2"></label>   


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?= form_close() ?>
</div>

<!-- LOGICA PARA EL CAMBIO DE FECHAS-->
<?php
$attributes = array('id' => 'FormCambioFecha', 'name' => 'FormCambioFecha');
echo form_open('Booking1', $attributes)
?>
<input type="hidden" name="origen" value="<?= $data_ida['origen'] ?>">
<input type="hidden" name="destino" value="<?= $data_ida['destino'] ?>">
<input type="hidden" name="hidd_name_ciu_orig" value="<?= $data_ida['nom_ciudad_orig'] ?>">
<input type="hidden" name="hidd_name_ciu_dest" value="<?= $data_ida['nom_ciudad_dest'] ?>">
<input type="hidden" name="tipo_viaje" value="<?= $tipo_viaje ?>">
<input type="hidden" name="date_from" value="<?= $date_from ?>">
<input type="hidden" name="date_to" value="<?= $date_to ?>">
<input type="hidden" name="cant_adultos" value="<?= $cant_adultos ?>">
<input type="hidden" name="cant_ninos" value="<?= $cant_ninos ?>">
<input type="hidden" name="cant_infantes" value="<?= $cant_infantes ?>">
<input type="hidden" id="position" name="position" value="<?= (isset($valueset_position)) ? $valueset_position : '' ?>">

<!--<input type="hidden" id="top" name="top" value="">-->
<?php
echo form_close();
?>
<script>
<?php if ($tipo_viaje === 'R') { ?>
    precio_total = document.getElementById("precio_total").value;
        var viajala_conversion_params = {
            event: 'redirect',
            supplier: 'starperu',
            origin: '<?= $data_ida['origen'] ?>',
            destination: '<?=  $data_ida['destino'] ?>',
            passengers: <?= (int) $cant_ninos + (int) $cant_adultos + (int) $cant_infantes ?>,
            outwardDate: '<?= (new DateTime(str_replace('/','-',$date_from)))->format('Y-m-d') ?>',
            inwardDate: '<?= (new DateTime(str_replace('/','-',$date_to)))->format('Y-m-d') ?>',
            /* outwardFlightNumbers: '2I<?= explode('|', $grupo_ida)[2] ?>', */
            /* inwardFlightNumbers: "2I<?= explode('|', $grupo_ida)[2] ?>,2I<?= explode('|', $grupo_retorno)[2] ?>", */
            /* price: precio_total, */
            // currency: 'USD'
        };
    <?php } else {
    ?>
        var viajala_conversion_params = {
            event: 'redirect',
            supplier: 'starperu',
            origin: '<?= $cod_origen ?>',
            destination: '<?= $cod_destino ?>',
            passengers: <?= (int) $cant_adl + (int) $cant_chd + (int) $cant_inf ?>,
            outwardDate: '<?= explode(' ', explode('|', $grupo_ida)[3])[0] ?>',
            outwardFlightNumbers: '2I<?= explode('|', $grupo_ida)[2] ?>',
            price: '<?= round($PrecioTotal, 0) ?>',
            currency: 'USD'
        };
    <?php
}
?>

</script>
<!-- FIN  LOGICA PARA EL CAMBIO DE FECHAS-->
<!-- Google Code for Cotizaciones Conversion Page -->
<!--<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 957770103;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "cxRBCK2q4mMQ99LZyAM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/957770103/?label=cxRBCK2q4mMQ99LZyAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-32584975-1', 'auto'); ga('require', 'displayfeatures'); ga('send', 'pageview'); </script> -->