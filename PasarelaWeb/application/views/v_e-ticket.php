<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-8">

            <div class="accordion destinos--2" id="accordionStar">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne" aria-controls="collapseOne">
                            <h3>Datos del Establecimiento:</h3>
                        </a>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionStar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-11">
                                    <table class="table resumen">
                                        <tbody>
                                            <tr>
                                                <th>Nombre del Establecimiento:</th>
                                                <td>Star Perú</td>
                                            </tr>
                                            <tr>
                                                <th>Teléfono</th>
                                                <td>(511) 705-9000</td>
                                            </tr>
                                            <tr>
                                                <th>Dirección Comercial</th>
                                                <td>Av. Comandante Espinar 331, Miraflores. Lima 18 - Perú</td>
                                            </tr>
                                            <tr>
                                                <th>Dominio</th>
                                                <td>www.starperu.com</td>
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
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>Apellidos / Nombres</th>
                                                <th>Documento</th>
                                                <th>Código de Reserva</th>
                                                <th>&nbsp;</th><!--                                                            
                                                <th>Boleto</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $pax = 1;
                                            foreach ($res_model_pasajero->Result() as $item) {
                                                ?>
                                                <tr>
                                                    <td>Pasajero <?= $pax ?></td>
                                                    <td><?php echo $item->nombres . " " . $item->apellidos; ?></td>
                                                    <td><?php echo $item->tipo_documento . " " . $item->num_documento; ?></td>                                                                      
                                                    <td><?php echo $item->num_ticket; ?></td>     
                                                    <td><button type="button" class="btn btn-outline-danger btn_ver_ticket" id="<?= $item->num_ticket ?>">Ver Ticket</button></td>
                                                </tr>
                                                <?php
                                                $pax++;
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" id="accordionStar">
                    <div class="card-header" id="headingThree">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            <h3>Datos del Viaje:</h3>
                        </a>
                    </div>
                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar" style="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-11">
                                    <table class="table resumen">
                                        <tbody>
                                            <tr>
                                                <th>Código de reserva:</th>
                                                <td><?php echo $res_model_vuelo->pnr ?></td>
                                            </tr>
                                            <tr>
                                                <th>Origen :</th>
                                                <td><?php echo $res_model_vuelo->origen ?></td>
                                            </tr>
                                            <tr>
                                                <th>Destino :</th>
                                                <td> <?php echo $res_model_vuelo->destino ?></td>
                                            </tr>

                                            <tr>
                                                <th>Hora Salida:</th>
                                                <td>
                                                    <?php
                                                    $hora_salida_Salida = new DateTime($res_model_vuelo->fechahora_salida_tramo_ida);
                                                    echo $hora_salida_Salida->format('H:i');
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr>
                                                <th>Hora Llegada :</th>
                                                <td>
                                                    <?php
                                                    $hora_salida_ida = new DateTime($res_model_vuelo->fechahora_llegada_tramo_ida);
                                                    echo $hora_salida_ida->format('H:i');
                                                    ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Vuelo Ida :</th>
                                                <td> <?php echo $res_model_vuelo->num_vuelo_ida ?></td>
                                            </tr>
                                            <?php if ($res_model_vuelo->num_vuelo_retorno != 'NULL') { ?>
                                                <tr>
                                                    <th>Vuelo Retorno :</th>
                                                    <td> <?php echo $res_model_vuelo->num_vuelo_retorno ?></td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-11">
                                    <table class="table resumen">
                                        <tbody>
                                            <tr>
                                                <td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#TerminosCondiciones">Ver condiciones</button></td>
                                                <!--<td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#PoliticasDevolucion">Politicas de devolución</button></td>-->
                                            </tr>
                                        </tbody>
                                    </table>
                                    </di</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>  
</div>
</main>
</div>