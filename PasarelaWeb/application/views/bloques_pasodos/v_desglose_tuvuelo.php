<div class="col-sm-12 col-md-4">
    <div class="card resumen destinos-2">
        <h2>Tu vuelo</h2>

        <?php
        $Direccion = TRUE;
        foreach ($Itinerario->OriginDestinationOption->FlightSegment as $clave => $valor) {
            ?>
            <h4><b><?= ($Direccion) ? 'Salida' : 'Retorno' ?>:</b></h4>
            <?php
            switch ($valor->DepartureAirport->attributes()->LocationCode) {
                case "LIM":
                    echo "Lima";
                    break;
                case "CJA":
                    echo "Cajamarca";
                    break;
                case "CUZ":
                    echo "Cuzco";
                    break;
                case "IQT":
                    echo "Iquitos";
                    break;
                case "PCL":
                    echo "Pucallpa";
                    break;
                case "TPP":
                    echo "Tarapoto";
                    break;
                case "CIX":
                    echo "Chiclayo";
                    break;
            }
            ?>( <?php echo ($valor->DepartureAirport->attributes()->LocationCode) ?>)
            >
            <?php
            switch ($valor->ArrivalAirport->attributes()->LocationCode) {
                case "LIM":
                    echo "Lima";
                    break;
                case "CJA":
                    echo "Cajamarca";
                    break;
                case "CUZ":
                    echo "Cuzco";
                    break;
                case "IQT":
                    echo "Iquitos";
                    break;
                case "PCL":
                    echo "Pucallpa";
                    break;
                case "TPP":
                    echo "Tarapoto";
                    break;
                case "CIX":
                    echo "Chiclayo";
                    break;
            }
            ?>
            ( <?php echo ($valor->ArrivalAirport->attributes()->LocationCode) ?>)

            <br>
            
         
            <?= $valor->attributes()->DepartureDateTime?> <br>
            Código de vuelo: <?= $valor->attributes()->FlightNumber ?> <br>
            0 escalas - <?php echo ($valor->DepartureAirport->attributes()->LocationCode) ?> > <?php echo ($valor->ArrivalAirport->attributes()->LocationCode) ?> 
            <div class="card gris">
                <h6>Pasajeros:</h6>
                <p>1 pasajero adulto</p>
                <h6>Equipaje permitido:</h6>
                <p>El equipaje permitido para ser facturado es de 1 pieza de hasta un maximo de 23kg, el equipaje de mano es de 1 pieza de hasta un maximo de 8kg.</p>
                <h6>Cambio:</h6>
                <p>Aplica cambio de nombre o ruta asumiendo un cargo por reemisión de usd $ 17.70 inc. 
Igv o su equivalente en moneda nacional.
Aplica cambios de fecha dentro de las 24 hrs y tienen un costo de $ 17.70 + reemisión + 
diferencia si lo hubiera y fuera de las 24 hrs se cobra reemisión de OW (7.08) ó RT(14.16).
De no encontrarse disponible con la misma tarifa deberá pagar la diferencia que se 
encuentre disponible al momento de hacer el cambio y un cargo por reemisión OW ($7.08)
 ó RT($14.16) según el boleto adquirido</p></div>
            <hr>
            <?php
            $Direccion = FALSE;
        }
        ?>

        <p>Si necesitas presentar tu boleto como factura, ingresa aquí el numero de RUC </p>
        <div class="form-group">
            <h6><strong>RUC:</strong</h6>
            <input type="text" class="form-control" aria-describedby="ruc" placeholder="ingresa tu numero de RUC" id="RUC" name="ruc">
        </div>
        <p>Si usted o uno de sus acompañantes requiere de un Servicio Especial, por favor comuníquelo a nuestro Call Center (01) 705 9000.</p>
        <hr>
        <h1 class="text-right"><b ><?= $PrecioTotal ?><small>$</small></b></h1>
        <h5 class="text-right">Precio Total</h5>

        <button type="submit" id="validacion_v" class="btn btn-primary btn-lg">Continuar</button>
    </div>
</div>