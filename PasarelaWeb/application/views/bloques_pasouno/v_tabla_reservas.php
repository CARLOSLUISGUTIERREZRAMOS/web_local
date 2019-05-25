<table class="table reservas">
    <?=$thead?>
    <tbody>
        <?php
        $Vuelos = json_decode(json_encode($Vuelos));
        foreach ($Vuelos as $key => $value) {
            ?>
        <tr>
                <td>
                    <p><b>Salida:</b> <span><?= (new DateTime($value->DepartureDateTime))->format('H:i:s') ?> hrs.</span></p>
                    <p><b>Llegada:</b> <span><?= (new DateTime($value->ArrivalDateTime))->format('H:i:s') ?> hrs.</span></p>
                    <p><small><b>Duración del vuelo:</b> <span><?= $value->JourneyDuration ?></span></small></p>
                    <p><small>[Nombre aeropuerto] <br>[nombre de ciudad de salida]</small></p>
                    <p><small>[Nombre aeropuerto] <br>[nombre de ciudad de destino]</small></p>
                </td>
                <td>
                    <p><small><b>Codigo de vuelo:</b> <?= $key ?></small></p>
                    <p><small><b>Compañia:</b> StarPerú</small></p>
                    <p><small><b>Aeronave:</b> Airbus Industrie A340-600</small></p>
                </td>
                <?php
                    $data['DataVuelo'] = $value;
                    $data['TipoVuelo'] = $TipoVuelo;
                    $data['DepartureDateTime'] = $value->DepartureDateTime;
                    $data['ArrivalDateTime'] = $value->ArrivalDateTime;
                    $data['key'] = $key;
                    $this->load->view('bloques_pasouno/v_tarifa_familia',$data);
                ?>
            </tr>
                <?php
            }
            ?>



    </tbody>
</table>