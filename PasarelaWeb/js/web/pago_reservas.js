$(function () {
    $('#redirect_pago_reserva').click(function () {
        var pnr = $('#pnr').val();
        $(location).attr("href", url);

    })

    $('#validacion_v').click(function (event) {
/* 
        var ValidacionCodigoDescuento = function(){
            $('')
        }
 */
        var bool2 = $('.vacios_radio').toArray().some(function (el) {
            return !($(el).is(':checked'));
        });


        if (bool2) {
            Mensaje = 'Debe Aceptar las condicciones ';
            $('#TxtMsg').html(Mensaje);
            $('#v_modal_error').modal('show');
            event.preventDefault();

        }


    });
});