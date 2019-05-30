<div class="container">
    <?= form_open('PasoFinal/ReprocesarTransaccion') ?>
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="accordion destinos--2" id="accordionStar">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne" aria-controls="collapseOne">
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

                                            <?php foreach ($Itinerarios as $Itinerario) { ?>
                                                <tr>
                                                    <td><?= (new DateTime(($Itinerario->Air->Reservation->attributes()->DepartureDateTime)))->format('d/M') ?></td>
                                                    <td><?= (new DateTime(($Itinerario->Air->Reservation->attributes()->DepartureDateTime)))->format('h:i') ?>/<?= (new DateTime(($Itinerario->Air->Reservation->attributes()->ArrivalDateTime)))->format('h:i') ?></td>
                                                    <td><?= $Itinerario->Air->Reservation->DepartureAirport->attributes()->LocationCode ?></td>
                                                    <td><?= $Itinerario->Air->Reservation->ArrivalAirport->attributes()->LocationCode ?></td>
                                                    <td><?= $Itinerario->Air->Reservation->attributes()->FlightNumber ?> <?= (strlen($Itinerario->Air->Reservation->attributes()->FlightNumber) == 4) ? ' | Operado por Peruavian' : '' ?></td>
                                                </tr>
                                            <?php }
                                            ?>
                                            <tr>
                                                <td>

                                                </td>

                                                <td>

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
                                            <?php foreach ($Pasajeros as $Pasajero) { ?>
                                                <tr>
                                                    <td><?php
                                                        $i = $i + 1;
                                                        echo "Pasajero" . " " . $i;
                                                        ?> </td>
                                                    <td><?= $Pasajero->Customer->attributes()->PassengerTypeCode ?></td>
                                                    <td><?= $Pasajero->Customer->PersonName->Surname ?>/<?= $Pasajero->Customer->PersonName->GivenName ?></td>
                                                    <td><?= $Pasajero->Customer->Document->attributes()->DocType ?> : <?= $Pasajero->Customer->Document->attributes()->DocID ?></td>
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
                                        <input type="text" class="form-control vacios" id="contacto" name="contacto" value="<?= strtoupper($Pasajeros[0]->Customer->PersonName->Surname) ?>/<?= strtoupper($Pasajeros[0]->Customer->PersonName->GivenName) ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-10">
                                    <div class="form-group">
                                        <label for="email">Correo electrónico:</label>
                                        <input type="text" class="form-control vacios " id="email" name="email" value="<?= strtoupper($Pasajeros[0]->Customer->ContactPerson->Email[0]) ?>" disabled>
                                    </div>
                                    <hr>
                                </div>
                                
                                 <div class="col-sm-12 col-md-5">
                                      <?php
                                        $digitos_tfn_contacto = (int) strlen($Pasajeros->Customer->ContactPerson->Telephone[0]);

                                        if ($digitos_tfn_contacto === 10) {
                                            $tlfn_contacto =  explode('P2', $Pasajeros->Customer->ContactPerson->Telephone[1])[1];
                                        } else {
                                            $tlfn_contacto = explode('P1', $Pasajeros->Customer->ContactPerson->Telephone[0])[1];
                                        }
                                        ?>
                                    <div class="form-group">
                                        <label for="num-loc">Número de contacto:</label>
                                        <input type="text" class="form-control" aria-describedby="num-loc" id="num-loc" name="num_tlfn" value="<?= $tlfn_contacto ?>" disabled>
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
                            $this->load->view('bloques_pasodos/v_desglose_tarjetas', $data)
                            ?>

                            <div class="row">
                                <div class="col-12">
                                    <br>
                                    <p># Web Check-in No aplica para vuelos operados por Peruvian, acercarse 2 hrs antes al counter para hacer su check-in gracias. </p>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck1">
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
                                <input type="text" class="form-control" aria-describedby="codres" id="codres" value=" <?= $TravelItinerary->ItineraryRef->attributes()->ID ?>" disabled>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div class="form-group">
                                <label for="montotrans">Monto de la transacción:</label>
                                <input type="text" class="form-control" aria-describedby="montotrans" id="montotrans" value=" USD <?= $TotalPagar  ?>" disabled>
                                <input type="hidden" value="<?= $res_model_vuelo->id ?>" name="reserva_id">
                                <input type="hidden" value="<?= $res_model_vuelo->email ?>" name="email">
                                <input type="hidden" value="<?= $res_model_vuelo->pnr ?>" name="pnr">
                                <input type="hidden" value="<?= $TravelItinerary->Remarks->Remark ?>" name="ruc">
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