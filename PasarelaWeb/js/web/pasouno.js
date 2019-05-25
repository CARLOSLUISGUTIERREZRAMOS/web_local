$(function () {

    var TarifaIda = 0;
    var TarifaRetorno = 0;
    var PrecioTotal = 0;
    var tipo_viaje;
    var cod_origen;
    var cod_destino;
    var cant_adl;
    var cant_chd;
    var cant_inf;
    var fecha_ida;
    var fecha_retorno;
    var ida_retorno;
    var grupo_retorno;

    var positionscreen = $('#position').val();

    if (positionscreen == 'headingTwo') {
        $('html,body').animate({
            scrollTop: $("#headingTwo").offset().top
        }, 2000);
    }
//    $('#headingTwo').scrollTop(50)


    $("input[name=grupo_ida]").click(function () {
        PrecioTotal = 0;
        TarifaIda = $('input:radio[name=grupo_ida]:checked').val();
        PrecioTotal += parseFloat(TarifaIda) + parseFloat(TarifaRetorno);
        $("#precio_total").html(PrecioTotal.toFixed(2));
    });
    $("input[name=grupo_retorno]").click(function () {
        PrecioTotal = 0;
        TarifaRetorno = $('input:radio[name=grupo_retorno]:checked').val();
        PrecioTotal += parseFloat(TarifaIda) + parseFloat(TarifaRetorno);
        grupo_retorno = $(this).val();
        $("#precio_total").html(PrecioTotal.toFixed(2));
    });

    $("body").on("click", ".dias_calculo", function () {
        var fecha_selected = $(this).attr('id');
        tramo = $(this).parent(".col").parent('.fechas').attr('id');
        if (tramo === 'to') {
            bloqueretorno = 'headingTwo';
            $('#position').val(bloqueretorno);
        } else {
            $('#position').val('');
        }

//        return false;
        $("input[name=date_" + tramo + "]").val(fecha_selected);
        $('#FormCambioFecha').submit();
    });


//********************** INI CODIGO DESACOPLADO DEL HTML*************************//
    $('.uno:input:radio').click(function () {
        if ($(this).parent("label").hasClass('current')) {

        } else {
            $('.uno:input:radio').parent("label").removeClass('current');
            $(this).parent("label").addClass('current');
        }
    });
    $('.dos:input:radio').click(function () {
        if ($(this).parent("label").hasClass('current')) {

        } else {
            $('.dos:input:radio').parent("label").removeClass('current');
            $(this).parent("label").addClass('current');
        }
    });
//********************** FIN CODIGO DESACOPLATO DEL HTML*************************+//

    var a = $('#R').attr('id');
    if (a === 'R') {
        $('#validate').click(function (event) {
            if (!($('input[name="grupo_ida"]').is(':checked'))) {
                Mensaje = 'Seleccione una Ruta de Ida';
                $('#TxtMsg').html(Mensaje);
                $('#v_modal_error').modal('show');
                event.preventDefault();
            } else if (!($('input[name="grupo_retorno"]').is(':checked'))) {
                Mensaje = 'Seleccione una Ruta de Vuelta';
                $('#TxtMsg').html(Mensaje);
                $('#v_modal_error').modal('show');
                event.preventDefault();
            }
        });
    }




    var a = $('#O').attr('id');
    if (a === 'O') {
        $('#validate').click(function (event) {
            if (!($('input[name="grupo_ida"]').is(':checked'))) {
                Mensaje = 'Seleccione una Ruta de Ida';
                $('#TxtMsg').html(Mensaje);
                $('#v_modal_error').modal('show');
                event.preventDefault();
            }
        });
    }

//    $(document).ready(function () {
    //IDA
    $("body").on("click", ".familia_promo_ida", function () {
//        $(".familia_simple_ida").click(function () {
        $("#titulo_ida").html('');
        $("#alex").html('');
        $("#titulo_ida").append("<h3>IDA</h3>")
        $("#alex").append
                ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases. </p>\n\
                    <p>• Plazo de compra de 6 hrs. .</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa.</p>\n\
                    <p>• Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de nombre con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de ruta con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo con cargo USD 17.70 .De ser el caso aplica diferencia tarifaria a la clase inmediata superior.  Aplica no show USD 11.80. Tarifa sujeta a cambios sin previo aviso.</p>\n\
                    <p>• Reembolsable en E-MPD (vale para futura transportación) con cargo administrativo de $23.60</p>");
    });
    $("body").on("click", ".familia_simple_ida", function () {
//        $(".familia_simple_ida").click(function () {
        $("#titulo_ida").html('');
        $("#alex").html('');
        $("#titulo_ida").append("<h3>IDA</h3>")
        $("#alex").append
                ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases</p>\n\
                    <p>• Plazo de compra de 6 hrs.</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa</p>\n\
                    <p>• Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo con cargo USD 17.70 De ser el caso aplica diferencia tarifaria a la clase inmediata superior. Aplica no show USD 11.80. Tarifa sujeta a cambios sin previo aviso.</p>\n\
                    <p>• Reembolsable en E-MPD (vale para futura transportación) con cargo administrativo de $23.60.</p>");
    });
    $("body").on("click", ".familia_extra_ida", function () {
//        $(".familia_extra_ida").click(function () {
        $("#titulo_ida").html('');
        $("#alex").html('');
        $("#titulo_ida").append("<h3>IDA</h3>")
        $("#alex").append
                ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases.</p>\n\
                    <p>• Plazo de compra de 6 hrs.</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa.</p>\n\
                    <p>•Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de nombre con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de nombre con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo con cargo USD 17.70 // De ser el caso aplica diferencia tarifaria a la clase inmediata superior. Aplica no show USD 11.80.  Tarifa sujeta a cambios sin previo aviso..</p>\n\
                    <p>• Reembolsable en E-MPD (vale para futura transportación) con cargo administrativo de $23.60.</p>");
    });

    $("body").on("click", ".familia_full_ida", function () {
//        $(".familia_full_ida").click(function () {
        $("#titulo_ida").html('');
        $("#alex").html('');
        $("#titulo_ida").append("<h3>IDA</h3>")

        $("#alex").append
                ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases.</p>\n\
                    <p>• Plazo de compra de 6 hrs.</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa.</p>\n\
                    <p>• Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de nombre sin cargo.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo sin cargo.  De ser el caso aplica diferencia tarifaria a la clase inmediata superior. Aplica no show USD 11.80. Tarifa sujeta a cambios sin previo aviso.</p>\n\
                    <p>• Reembolsable en CASH o E-MPD con cargo administrativo de $ 23.60.</p>    ");
    });
    //VUELTA



    $("body").on("click", ".familia_promo_vuelta", function () {
//        $(".familia_simple_vuelta").click(function () {
        $("#titulo_vuelta").html('');
        $("#alex2").html('');
        $("#titulo_vuelta").append("<h3>VUELTA</h3>")

        $("#alex2").append
                   ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases. </p>\n\
                    <p>• Plazo de compra de 6 hrs. .</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa.</p>\n\
                    <p>• Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de nombre con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de ruta con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo con cargo USD 17.70 .De ser el caso aplica diferencia tarifaria a la clase inmediata superior.  Aplica no show USD 11.80. Tarifa sujeta a cambios sin previo aviso.</p>\n\
                    <p>• Reembolsable en E-MPD (vale para futura transportación) con cargo administrativo de $23.60</p>");
    });
    $("body").on("click", ".familia_simple_vuelta", function () {
//        $(".familia_simple_vuelta").click(function () {
        $("#titulo_vuelta").html('');
        $("#alex2").html('');
        $("#titulo_vuelta").append("<h3>VUELTA</h3>")

        $("#alex2").append
               ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases</p>\n\
                    <p>• Plazo de compra de 6 hrs.</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa</p>\n\
                    <p>• Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo con cargo USD 17.70 De ser el caso aplica diferencia tarifaria a la clase inmediata superior. Aplica no show USD 11.80. Tarifa sujeta a cambios sin previo aviso.</p>\n\
                    <p>• Reembolsable en E-MPD (vale para futura transportación) con cargo administrativo de $23.60.</p>");
    });
    $("body").on("click", ".familia_extra_vuelta", function () {
//        $(".familia_extra_vuelta").click(function () {
        $("#titulo_vuelta").html('');
        $("#alex2").html('');
        $("#titulo_vuelta").append("<h3>VUELTA</h3>")
        $("#alex2").append
             ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases.</p>\n\
                    <p>• Plazo de compra de 6 hrs.</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa.</p>\n\
                    <p>•Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de nombre con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de nombre con cargo USD 17.70.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo con cargo USD 17.70 // De ser el caso aplica diferencia tarifaria a la clase inmediata superior. Aplica no show USD 11.80.  Tarifa sujeta a cambios sin previo aviso..</p>\n\
                    <p>• Reembolsable en E-MPD (vale para futura transportación) con cargo administrativo de $23.60.</p>");
    });

    $("body").on("click", ".familia_full_vuelta", function () {
//        $(".familia_full_vuelta").click(function () {
        $("#titulo_vuelta").html('');
        $("#alex2").html('');
        $("#titulo_vuelta").append("<h3>VUELTA</h3>")
        $("#alex2").append
                ("<p>• Máx. de estadía de 180 días. </p>\n\
                    <p>• Combinable con otras clases.</p>\n\
                    <p>• Plazo de compra de 6 hrs.</p>\n\
                    <p>• Aplica niño al 50% sobre tarifa.</p>\n\
                    <p>• Aplica infante al 10% sobre tarifa.</p>\n\
                    <p>• Un (1) equipaje de bodega de 23kg, y uno (1) de mano de 8kg.</p>\n\
                    <p>• Aplica cambio de nombre sin cargo.</p>\n\
                    <p>• Aplica cambio de fecha y/o vuelo sin cargo.  De ser el caso aplica diferencia tarifaria a la clase inmediata superior. Aplica no show USD 11.80. Tarifa sujeta a cambios sin previo aviso.</p>\n\
                    <p>• Reembolsable en CASH o E-MPD con cargo administrativo de $ 23.60.</p>    ");
    });


});
//
$(function () {
    tipo_viaje = $('#tipo_viaje').val();
    if (tipo_viaje === 'O') {
        $('#collapseOne .active')[0].scrollIntoView({inline: 'center'});
    } else if(tipo_viaje === 'R'){
        $('#collapseTwo .active')[0].scrollIntoView({inline: 'center'});
        $('#collapseOne .active')[0].scrollIntoView({inline: 'center'});
    }
});


