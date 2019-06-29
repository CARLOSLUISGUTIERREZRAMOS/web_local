
        <div class="container loader">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="alert alert-info" role="alert">
                        <strong>Tome nota de su proceso de pago.</strong><br>
                    </div>
                    <div class="accordion destinos--2" id="accordionStar">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class = "accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne"  aria-controls="collapseOne">
                                    <h3>Datos del Establecimientoo:</h3>
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
                                    <h3>Datos de la Compra:</h3>
                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-11">
                                            <table class="table resumen">
                                                <tbody>
                                                    <tr>
                                                        <th>Código de reserva:</th>
                                                        <td><?=$pnr?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Número de pedido:</th>
                                                        <td><?=$reserva_id?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Moneda:</th>
                                                        <td>USD</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Monto de la Transacción</th>
                                                        <td><?=$total_pagar?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Descripción del Vuelo</th>
                                                        <td><?php
                                                        if($tipo_viaje === 'R'){
                                                            echo $origen . ' - ' . $destino .' - ' .$origen;
                                                        }else if($tipo_viaje === 'O'){
                                                            echo $origen . ' - ' . $destino;
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
                            <div class="card-header" id="headingThree">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <h3>Sugerencia:</h3>
                                </a>
                            </div>
                            <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-11">
                                            <br>
                                            <div class="alert alert-info" role="alert">
                                                Por favor tome nota de su código de reserva: <?=$pnr?> e intente su pago nuevamente ingresando <a href="<?=base_url()?>PagoReservas/ReprocesarPago?pnr=<?=$pnr?>&reserva_id=<?=$reserva_id?>" id="redirect_pago_reserva">aquí</a>
                                            </div>
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
                                        <input type="text" class="form-control" aria-describedby="nomest" id="nomest" value="Star Perú" disabled>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <div class="form-group">
                                        <label for="codres">Código de Reserva:</label>
                                        <input type="text" class="form-control" aria-describedby="codres" id="codres" value="<?=$pnr?>" disabled>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <div class="form-group">
                                        <label for="montotrans">Monto de la transacción:</label>
                                        <input type="text" class="form-control" aria-describedby="montotrans" id="montotrans" value="<?=$total_pagar?>" disabled>
                                    </div>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    