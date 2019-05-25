<?php

    function ArmarDataParaInsertarPE($reserva_id, $cip, $TotalPagar) {
        $FechaOperacion = date("Y-m-d H:i:s");
        $data = array(
            'reserva_id' => $reserva_id,
            'cip' => $cip,
            'amount' => $TotalPagar,
            'fecha_operacion' => $FechaOperacion
        );
        return $data;
    }