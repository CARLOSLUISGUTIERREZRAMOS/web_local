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
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-11">
                                    <table class="table resumen">
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>Apellidos / Nombres</th>
                                                <th>Documento</th>
                                                <th>N° Ticket</th>
                                                <th>Boleto</th><!--                                                            
                                                <th>Boleto</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $pax = 1;
                                            $indice = 0;
                                             foreach ($Pasajeros as $Pasajero) { ?>
                                                
                                                <tr>
                                                    <td>Pasajero <?= $pax ?></td>
                                                    <td><?= $Pasajero->Customer->PersonName->Surname ?>/<?= $Pasajero->Customer->PersonName->GivenName ?></td>
                                                    <td><?= $Pasajero->Customer->Document->attributes()->DocType ?> : <?= $Pasajero->Customer->Document->attributes()->DocID ?></td>
                                                    <td><?= $TravelItinerary->ItineraryInfo->Ticketing[$indice]->attributes()->eTicketNumber ?></td>
                                                    <td><button type="button" class="btn btn-outline-danger btn_ver_ticket" id="<?= $TravelItinerary->ItineraryInfo->Ticketing[$indice]->attributes()->eTicketNumber ?>">Ver Ticket</button></td>
                                                </tr>
                                                <?php
                                                $pax++;
                                                $indice++;
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
                        <div class="card-body table-responsive">
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