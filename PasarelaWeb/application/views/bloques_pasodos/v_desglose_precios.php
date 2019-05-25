<div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar">
    <div class="card-body table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Tarifa</th>
                    <th>TUUA</th>
                    <th>IGV</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($DesglosePrecios as $key => $valor) {
                    ?>
                    <tr>
                        <td><?= $valor->PassengerTypeQuantity->attributes()->Code ?></td>
                        <td><?= $valor->PassengerFare->BaseFare->attributes()->Amount ?> $</td>
                        <?php
                        $suma_igv_tuua = 0;
                        foreach ($valor->PassengerFare->Taxes as $key => $Tax) {

                            foreach ($Tax as $key => $ItemTaxe) {
                                $suma_igv_tuua += (double)$ItemTaxe->attributes()->Amount;
                                ?>
                                <td><?= (double)$ItemTaxe->attributes()->Amount ?></td>
                                <?php
                            }
                        }
                        ?>
                        <td>X<?= $valor->PassengerTypeQuantity->attributes()->Quantity ?></td>
                        <td><?=$suma_igv_tuua + (double)$valor->PassengerFare->BaseFare->attributes()->Amount?></td>
                    </tr>
                    <?php
                }
                ?>

            </tbody>
        </table>
    </div>
</div>