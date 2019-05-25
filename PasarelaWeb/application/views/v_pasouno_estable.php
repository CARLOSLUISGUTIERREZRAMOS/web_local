<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Las Mejores tarifas aéreas para peruanos y extranjeros. Vuela por el Perú: Cusco, Tarapoto, Iquitos, Pucallpa, Lima; promociones especiales">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Aerolíneas StarPerú</title>
        <?= link_tag('css/bootstrap.css') ?>
        <?= link_tag('css/font-awesome.css') ?>
        <?= link_tag('css/main.css') ?>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        <style>
            .enlace_desactivado {
                pointer-events: none;
                cursor: default;
            }
        </style>
    </head>
    <body class="internas nohero">
        <div class="interfaz">
            <?php
            $this->load->view('bloques_pasouno/v_header');
//            echo validation_errors('<div class="error"> que esta pasndo</div>');
            echo form_open('PasoDos');
            ?>
            <main class="contenidos">
                <div class="container">
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
                                        <h5>Precio Total</h5>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="hidden" name="cod_origen" value="<?= $data_ida['origen'] ?>">
                                        <input type="hidden" name="cod_destino" value="<?= $data_ida['destino'] ?>">
                                        <input type="hidden" name="geoip_pais" value="<?= $geoip_pais ?>">
                                        <input type="hidden" name="geoip_ciudad" value="<?= $geoip_ciudad ?>">
                                        <input type="hidden" name="fecha_ida" value="<?= fecha_iso_8601($date_from) ?>">
                                        <input type="hidden" name="fecha_retorno" value="<?= fecha_iso_8601($date_to) ?>">
                                        <input type="hidden" name="tipo_viaje" value="<?= $tipo_viaje ?>">
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
                                                        <p><small>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </main>    

            <?php $this->load->view('bloques_pasouno/v_footer') ?>
            <?= form_close() ?>
        </div>
        <?php
        $attributes = array('id' => 'FormCambioFecha', 'name' => 'FormCambioFecha');
        echo form_open('', $attributes)
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
        <input type="hidden" id="position" name="position" value="<?= (isset($valueset_position)) ? $valueset_position : ''?>">
        <!--<input type="hidden" id="top" name="top" value="">-->
        <?php
        echo form_close();
        ?>
        <?= script_tag('js/jquery.min.js'); ?>
        <?= script_tag('js/popper.min.js'); ?>
        <?= script_tag('js/bootstrap.min.js'); ?>
        <?= script_tag('js/web/pasouno.js'); ?>
    </body>
</html>
<?php $this->load->view('templates/v_error') ?>