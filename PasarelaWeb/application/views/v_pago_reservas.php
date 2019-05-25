    
<div class="container">
        <?= form_open('PasoFinal/ReprocesarTransaccion') ?>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="accordion destinos--2" id="accordionStar">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <a class = "accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne"  aria-controls="collapseOne">
                                <h3>Información del Vuelo:</h3>
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionStar">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-11">
                                        <table class="table resumen">
                                            <thead>
                                                <tr>
                                                    <th>Día</th>
                                                    <th>Salida / Llegada</th>
                                                    <th>Origen</th>
                                                    <th>Destino</th>
                                                    <th>Vuelo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <?php
                                                        $fecha_hora_salida_ida = Fecha_dia_mes($res_model_vuelo->fechahora_salida_tramo_ida);
                                                        echo $fecha_hora_salida_ida
                                                        ?> </td>
                                                    <td>
                                                        <?php
                                                        $hora_salida_ida1 = new DateTime($res_model_vuelo->fechahora_salida_tramo_ida);
                                                        $hora_salida_vuelta1 = new DateTime($res_model_vuelo->fechahora_llegada_tramo_ida);
                                                        echo $hora_salida_ida1->format('H:i') . "  /  " . $hora_salida_vuelta1->format('H:i');
                                                        ?></td>
                                                    <td><?php echo $res_model_vuelo->origen; ?></td>
                                                    <td><?php echo $res_model_vuelo->destino; ?></td>
                                                    <td><?php
                                                        if ($res_model_vuelo->cod_compartido_vuelo_ida == !"NO") {

                                                            echo $res_model_vuelo->num_vuelo_ida . "(operado por Peruvian)";
                                                        } else {
                                                            echo $res_model_vuelo->num_vuelo_ida;
                                                        }
                                                        ?>
                                                    </td>                                                              
                                                </tr>

                                                <tr>
                                                    <td> 
                                                        <?php
                                                        $fechahora_salida_tramo_retorno = Fecha_dia_mes($res_model_vuelo->fechahora_salida_tramo_retorno);
                                                        echo $fechahora_salida_tramo_retorno
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $hora_salida_ida2 = new DateTime($res_model_vuelo->fechahora_salida_tramo_retorno);
                                                        $hora_salida_vuelta2 = new DateTime($res_model_vuelo->fechahora_llegada_tramo_retorno);
                                                        echo $hora_salida_ida2->format('H:i') . "  /  " . $hora_salida_vuelta2->format('H:i');
                                                        ?>
                                                    </td>
                                                    <td><?php echo $res_model_vuelo->destino; ?></td>
                                                    <td><?php echo $res_model_vuelo->origen; ?></td>
                                                    <td><?php
                                                        if ($res_model_vuelo->cod_compartido_vuelo_retorno === "P9") {

                                                            echo $res_model_vuelo->num_vuelo_retorno . "(operado por Peruvian)";
                                                        } else {
                                                            echo $res_model_vuelo->num_vuelo_retorno;
                                                        }
                                                        ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="accordionStar">
                        <div class="card-header" id="headingTwo">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h3>Datos de Pasajeros:</h3>
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-11">
                                        <table class="table resumen">
                                            <?php $i = 0 ?>
                                            <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>Tipo</th>
                                                    <th>Apellidos / Nombres</th>
                                                    <th>Documento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($res_model_pasajero->Result() as $item) { ?>
                                                    <tr>


                                                        <td><?php
                                                            $i = $i + 1;
                                                            echo "Pasajero" . " " . $i;
                                                            ?> </td>
                                                        <td><?php
                                                            switch ($item->tipo_pasajero) {
                                                                case "ADT": echo 'ADULTO';
                                                                    break;
                                                                case "INF":echo 'INFANTE';
                                                                    break;
                                                                case "CNN":echo 'NIÑO';
                                                                    break;
                                                            }
                                                            ?></td>
                                                        <td><?php echo $item->apellidos . " " . $item->nombres ?></td>
                                                        <td><?php echo $item->tipo_documento . " :  " . $item->num_documento ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--ANALIZAR -- PROBLEMA CON ESTE BLOQUE -- ROMPE LAS FUENTES HTML -->
                    <div class="card" id="accordionStar">
                        <div class="card-header" id="headingThree">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h3>Información de Contacto:</h3>
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <p>Estos datos son necesarios para enviar notificaciones y mensajes relacionados a tu compra, cambios en el vuelo u otros.</p>
                                    </div>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="form-group">
                                            <label for="contacto">Contacto:</label>
                                            <input type="text" class="form-control vacios" id="contacto" name="contacto" value="<?= strtoupper($res_model_vuelo->nombres) . ' ' . strtoupper($res_model_vuelo->apellidos) ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="form-group">
                                            <label for="email">Correo electrónico:</label>
                                            <input type="text" class="form-control vacios " id="email" name="email" value="<?= $res_model_vuelo->email ?>" disabled>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="pre-loc">Prefijo país:</label>
                                        <div class="select">

                                            <select name="ddi_pais_tlfn">
                                                <?php foreach ($cod_ddi_paises->result() as $pais) { ?>
                                                    <option value="<?= $pais->ddi ?>" <?= ($pais->ddi == '+51') ? 'selected' : '' ?>><?= $pais->codigo_pais . ' ' . $pais->ddi ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="select__arrow"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="region">Región:</label>
                                            <input type="text" class="form-control" aria-describedby="region" id="region" name="region_tlfn" value="<?= ($res_model_vuelo->pre_telefono === "NULL") ? '' : $res_model_vuelo->pre_telefono ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group">
                                            <label for="num-loc">Número local (fijo):</label>
                                            <input type="text" class="form-control" aria-describedby="num-loc" id="num-loc" name="num_tlfn" value="<?= $res_model_vuelo->num_telefono ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label>Prefijo país:</label>
                                        <div class="select">
                                            <select name="ddi_pais_cel">
                                                <?php foreach ($cod_ddi_paises->result() as $pais) { ?>
                                                    <option value="<?= $pais->ddi ?>" <?= ($pais->ddi == '+51') ? 'selected' : '' ?>><?= $pais->codigo_pais . ' ' . $pais->ddi ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                            <div class="select__arrow"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="region2">Región:</label>
                                            <input type="text" class="form-control" aria-describedby="region2" id="region2" name="region_cel" value="<?= ($res_model_vuelo->pre_celular === "NULL") ? '' : $res_model_vuelo->pre_celular ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group">
                                            <label for="num-loc2">Número local (celular):</label>
                                            <input type="text" class="form-control" aria-describedby="num-loc2" id="num-loc2" name="num_cel" value="<?= $res_model_vuelo->num_celular ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                       <!--ANALIZAR -- PROBLEMA CON ESTE BLOQUE -- ROMPE LAS FUENTES HTML -->
                    <div class="card" id="accordionStar">
                        <div class="card-header" id="headingFour">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseFour" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <h3>Forma de pago:</h3>
                            </a>
                        </div>
                        <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionStar">
                            <div class="card-body">
                                    
                                
                                <?php 
                                
                                $data['datetime_departure'] = $res_model_vuelo->fechahora_salida_tramo_ida;
                                $this->load->view('bloques_pasodos/v_desglose_tarjetas',$data)?>
                                
                                <div class="row">
                                <div class="col-12">
                                    <br><p># Web Check-in No aplica para vuelos operados por Peruvian, acercarse 2 hrs antes al counter para hacer su check-in gracias. </p>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input vacios_radio"  type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Acepto las condiciones de compra
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#TerminosCondiciones">Ver condiciones</button></td>
                                    <!--<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ver condiciones</button>-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12"><br></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck2">
                                        <label class="form-check-label" for="defaultCheck2">
                                            Acepto las condiciones de Transporte.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#ModalCondiciones_Transporte">Ver condiciones</button></td>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card resumen destinos-2">
                    <table>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <label for="nomest">Nombre del establecimiento:</label>
                                    <input type="text" class="form-control" aria-describedby="nomest" id="nomest" value="STAR PERU" disabled>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <label for="codres">Código de Reserva:</label>
                                    <input type="text" class="form-control" aria-describedby="codres" id="codres"  value=" <?php echo $res_model_vuelo->pnr ?>" disabled>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <label for="montotrans">Monto de la transacción:</label>
                                    <input type="text" class="form-control" aria-describedby="montotrans" id="montotrans" value=" USD <?php echo $res_model_vuelo->total ?>" disabled>
                                    <input type="hidden" value="<?= $res_model_vuelo->id ?>" name="reserva_id">
                                    <input type="hidden" value="<?= $res_model_vuelo->email ?>" name="email">
                                    <input type="hidden" value="<?= $res_model_vuelo->pnr ?>" name="pnr">
                                    <input type="hidden" value="<?= $res_model_vuelo->ruc ?>" name="ruc">
                                    <input type="hidden" value="<?= $res_model_vuelo->tipo_documento ?>" name="tipo_documento_adl_1">
                                    <input type="hidden" value="<?= $res_model_vuelo->num_documento ?>" name="numdoc_adl_1">
                                    <input type="hidden" value="<?= $res_model_vuelo->total_pagar ?>" name="total_pagar">

                                </div>
                            </th>

                        </tr>

                    </table><br>
                    <button type="submit" id="validacion_v" class="btn btn-primary btn-lg">Continuar</button>
                </div>

            </div>
        </div>  
        <?= form_close() ?>
    </div>

