<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="https://cdn.viajala.com/tracking/conversion.js"></script>
    </head>
    <body>
    </body>
    <script>
        var viajala_conversion_params = {
            supplier: 'starperu',
            origin: '<?= $data_reserva->origen ?>',
            destination: '<?= $data_reserva->destino ?>',
            grossBooking: '<?= round($data_reserva->total_pagar, 0) ?>',
            currency: 'USD'
        };
    </script>
</html>
