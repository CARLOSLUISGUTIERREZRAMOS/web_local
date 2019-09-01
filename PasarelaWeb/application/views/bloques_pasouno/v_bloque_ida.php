<div class="card" id="card_ida">
    <div class="card-header" id="headingOne">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne" aria-controls="collapseOne">
            <h3>Seleccione su vuelo de Ida:</h3>
        </a>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionStar2">
        <div class="card-body">
            <h5> <?= $nom_ciudad_orig ?>(<?= $origen ?>) &gt; <?= $nom_ciudad_dest ?> (<?= $destino ?>) - <small><?= $date_from ?></small></h5>
            <div class="parentdiv">
                <div class="row no-gutters fechas" id="from">
                    <label id="<?= $tipo_viaje ?>"></label>
                    <div class="col"><a href="#" class="dias dias_calculo <?= ValidarFechaIda(RestarSumarFecha($date_from, '-3'), $date_to, $tipo_viaje) ?>" id="<?= RestarSumarFecha($date_from, '-3') ?>"><?= $tarifaMenorDiasAntesTresI?>$<small><?= FechaOperaLetras_ES($date_from, '-3') ?></small></a></div>
                    <div class="col"><a href="#" class="dias dias_calculo <?= ValidarFechaIda(RestarSumarFecha($date_from, '-2'), $date_to, $tipo_viaje) ?>" id="<?= RestarSumarFecha($date_from, '-2') ?>"><?= $tarifaMenorDiasAntesDosI?>$<small><?= FechaOperaLetras_ES($date_from, '-2') ?></small></a></div>
                    <div class="col"><a href="#" class="dias dias_calculo <?= ValidarFechaIda(RestarSumarFecha($date_from, '-1'), $date_to, $tipo_viaje) ?>" id="<?= RestarSumarFecha($date_from, '-1') ?>"><?= $tarifaMenorDiasAntesUnoI?>$<small><?= FechaOperaLetras_ES($date_from, '-1') ?></small></a></div>
                    <div class="col"><a href="#" class="dias active"><?= $tarifa_menor ?>$ <small><?= FechaLetras_ES($date_from, 'short') ?></small></a></div>
                    <div class="col"><a href="#" class="dias dias_calculo <?= ValidarFechaIda(RestarSumarFecha($date_from, '+2'), $date_to, $tipo_viaje) ?>" id="<?= RestarSumarFecha($date_from, '+1') ?>"><?= $tarifaMenorDiasDespuesUnoI?>$  <small><?= FechaOperaLetras_ES($date_from, '+1') ?></small></a></div>
                    <div class="col"><a href="#" class="dias dias_calculo <?= ValidarFechaIda(RestarSumarFecha($date_from, '+1'), $date_to, $tipo_viaje) ?>" id="<?= RestarSumarFecha($date_from, '+2') ?>"><?= $tarifaMenorDiasDespuesDosI?>$<small><?= FechaOperaLetras_ES($date_from, '+2') ?></small></a></div>
                    <div class="col"><a href="#" class="dias dias_calculo <?= ValidarFechaIda(RestarSumarFecha($date_from, '+3'), $date_to, $tipo_viaje) ?>" id="<?= RestarSumarFecha($date_from, '+3') ?>"><?= $tarifaMenorDiasDespuesTresI?>$ <small><?= FechaOperaLetras_ES($date_from, '+3') ?></small></a></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <form action="">
                            <table class="table reservas">
                                <thead>
                                    <tr>
                                        <th><?= FechaLetras_ES(fecha_iso_8601($date_from), 'large') ?></th>
                                        <th></th>
                                        <th>PROMO</th>
                                        <th>SIMPLE</th>
                                        <th>EXTRA</th>
                                        <th>FULL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($mostrar_bloque_vuelos === TRUE) {
                                        ?>
                                        <?php
                                        foreach ($json as $flight => $value) {
                                            $codigo_compartido = (isset($value->Code)) ? $value->Code : 'NO';
                                            ?>

                                            <tr>
                                                <td>
                                                    <p><b>Salida:</b> <span><?= ObtenerHoraVuelo($value->DepartureDateTime) ?> hrs.</span></p>
                                                    <p><b>Llegada:</b> <span><?= ObtenerHoraVuelo($value->ArrivalDateTime) ?> hrs.</span></p>
                                                    <p><small><b>Duración del vuelo:</b> <span><?= FormarDuracionVuelo($value->JourneyDuration) ?></span></small></p>
                                                    <p><small><?= ObtenerNombreAeropuerto($origen) ?> <br><?= $nom_ciudad_orig ?></small></p>
                                                    <p><small><?= ObtenerNombreAeropuerto($destino) ?> <br><?= $nom_ciudad_dest ?></small></p>
                                                </td>
                                                <td>
                                                    <p><small><b>Codigo de vuelo:</b> <?= $flight ?></small></p>
                                                    <p><small><b>Compañia:</b> <?= (isset($value->Code) && $value->Code == 'P9' ) ? 'Peruvian' : 'StarPerú'; ?> </small></p>
                                                    <!--<p><small><b>Aeronave:</b> Airbus Industrie A340-600</small></p>-->
                                                    <p><small> <?= $origen ?> &gt; <?= $destino ?></small></p>
                                                </td>
                                                <?php
                                                if (isset($value->FAMILIA->PROMO)) {
                                                    if ((int) $value->FAMILIA->PROMO->ResBookDesigQuantity < $CantTotalPax) {
                                                        ?>
                                                        <td>
                                                            <div class="form-check-nopacks">
                                                                
                                                            </div>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label familia_promo_ida" >
                                                                    <input class="form-check-input uno familia_promo_ida" type="radio" name="grupo_ida" id="exampleRadios2" value="<?= $value->FAMILIA->PROMO->Tarifa . '|' . $value->FAMILIA->PROMO->Clase . '|' . $flight . '|' . $value->DepartureDateTime . '|' . $value->ArrivalDateTime . '|' . $codigo_compartido ?>">
                                                                    <span><?= $value->FAMILIA->PROMO->Tarifa ?>$</span>
                                                                    <span class="infomas">
                                                                        <div class="dropdown">
                                                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->FAMILIA->PROMO->ResBookDesigQuantity ?> últimos asientos <br> <b>Condiciones</b></a>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                Máx. de estadía de 180 días<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Combinable con otras clases<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Plazo de compra de 6 hrs. <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica niño al 50% sobre tarifa<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica infante al 10% sobre tarifa <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica cambio de nombre con cargo USD 17.70<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica cambio de ruta con cargo USD 17.70<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica cambio de fecha y/o vuelo con cargo USD 17.70 // 
                                                                                De ser el caso aplica diferencia tarifaria a la clase inmediata superior. 
                                                                                Aplica no show USD 11.80. 
                                                                                Tarifa sujeta a cambios sin previo aviso.<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Reembolsable en E-MPD (vale para futura transportación) 
                                                                                con cargo administrativo de $23.60.<br>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </td>   
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <td>
                                                        <div class="form-check">
                                                        </div>
                                                    </td>
                                                    <?php
                                                }

                                                if (isset($value->FAMILIA->SIMPLE)) {
                                                    if ((int) $value->FAMILIA->SIMPLE->ResBookDesigQuantity < $CantTotalPax) {
                                                        ?>
                                                        <td>
                                                            <div class="form-check-nopacks">
                                                            </div>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label" >
                                                                    <input class="form-check-input uno familia_simple_ida" type="radio" name="grupo_ida" id="exampleRadios2" value="<?= $value->FAMILIA->SIMPLE->Tarifa . '|' . $value->FAMILIA->SIMPLE->Clase . '|' . $flight . '|' . $value->DepartureDateTime . '|' . $value->ArrivalDateTime . '|' . $codigo_compartido ?>">
                                                                    <span><?= $value->FAMILIA->SIMPLE->Tarifa ?>$</span>
                                                                    <span class="infomas">
                                                                        <div class="dropdown">
                                                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->FAMILIA->SIMPLE->ResBookDesigQuantity ?> últimos asientos <br> <b>Condiciones</b></a>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                Máx. de estadía de 180 días<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Combinable con otras clases <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Plazo de compra de 6 hrs.<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica niño al 50% sobre tarifa<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica infante al 10% sobre tarifa<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica cambio de nombre con cargo USD 17.70.<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica cambio de fecha y/o vuelo con cargo USD 17.70 // 
                                                                                De ser el caso aplica diferencia tarifaria a la clase inmediata superior. 
                                                                                Aplica no show USD 11.80. 
                                                                                Tarifa sujeta a cambios sin previo aviso.<br>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </td>   

                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <td>
                                                        <div class="form-check">

                                                        </div>
                                                    </td>
                                                    <?php
                                                }

                                                if (isset($value->FAMILIA->EXTRA)) {
                                                    if ((int) $value->FAMILIA->EXTRA->ResBookDesigQuantity < $CantTotalPax) {
                                                        ?>
                                                        <td>
                                                            <div class="form-check-nopacks">

                                                            </div>
                                                        </td>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label" >
                                                                    <input class="form-check-input uno familia_extra_ida" type="radio" name="grupo_ida" id="exampleRadios2" value="<?= $value->FAMILIA->EXTRA->Tarifa . '|' . $value->FAMILIA->EXTRA->Clase . '|' . $flight . '|' . $value->DepartureDateTime . '|' . $value->ArrivalDateTime . '|' . $codigo_compartido ?>">
                                                                    <span><?= $value->FAMILIA->EXTRA->Tarifa ?>$</span>
                                                                    <span class="infomas">
                                                                        <div class="dropdown">
                                                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->FAMILIA->EXTRA->ResBookDesigQuantity ?> últimos asientos <br> <b>Condiciones</b></a>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                Máx. de estadía de 180 días <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Combinable con otras clases <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Plazo de compra de 6 hrs <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica niño al 50% sobre tarifa <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica infante al 10% sobre tarifa <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica cambio de nombre con cargo USD 17.70<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Reembolsable en E-MPD (vale para futura transportación) 
                                                                                con cargo administrativo de $23.60<br>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </td>   
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <td>
                                                        <div class="form-check">

                                                        </div>
                                                    </td>
                                                    <?php
                                                }
                                                if (isset($value->FAMILIA->FULL)) {
                                                    if ($value->FAMILIA->FULL->ResBookDesigQuantity < $CantTotalPax) {
                                                        ?>
                                                        <td>
                                                            <div class="form-check-nopacks">

                                                            </div>
                                                        </td>

                                                        <?php
                                                    } else {
                                                        ?>

                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label" >
                                                                    <input class="form-check-input uno familia_full_ida" type="radio" name="grupo_ida" id="exampleRadios2" value="<?= $value->FAMILIA->FULL->Tarifa . '|' . $value->FAMILIA->FULL->Clase . '|' . $flight . '|' . $value->DepartureDateTime . '|' . $value->ArrivalDateTime . '|' . $codigo_compartido ?>">
                                                                    <span><?= $value->FAMILIA->FULL->Tarifa ?>$</span>
                                                                    <span class="infomas">
                                                                        <div class="dropdown">
                                                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->FAMILIA->FULL->ResBookDesigQuantity ?> últimos asientos <br> <b>Condiciones</b></a>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                Máx. de estadía de 180 días<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Combinable con otras clases<br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Plazo de compra de 6 hrs. <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica niño al 50% sobre tarifa <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica infante al 10% sobre tarifa <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Aplica cambio de nombre sin cargo <br>
                                                                                <div class="dropdown-divider"></div>
                                                                                Reembolsable en CASH o E-MPD 
                                                                                con cargo administrativo de $ 23.60 <br>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </td>   

                                                        <?php
                                                    }
                                                    ?>

                                                <?php } else {
                                                    ?>
                                                    <td>
                                                        <div class="form-check">

                                                        </div>
                                                    </td>
                                                    <?php
                                                }
                                                ?>

                                            <tr>
                                                <?php
                                            }
                                            ?>
                                        <?php } else {
                                            ?>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                No existen vuelos para esta fecha.
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>