$(function () {
    var documento;
    var email1;
    var tarjeta_set;
    var cc_code;
    var descuento_aplicado = false;
    $(document).ready(function () {

        MostrarInputCodigoDescuento('VI');

    });
    $("body").on("change", "#select_cards", function () {
        OcultarInputCodigoDescuento();
        tarjeta_set = $(this).val();
        switch (tarjeta_set) {
            case 'TC_V': //VISA
                cc_code = 'VI';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_visa_opc2.png");
                break;
            case 'TC_D': //DINERS
                cc_code = 'DC';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_diners.png");
                break;
            case 'TC_M': // MASTERCARD
                cc_code = 'MC';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_mastercard.png");
                break;
            case 'TC_A': // Anerican Express
                cc_code = 'AX';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_americanexpress.png");
                break;
            case 'PP':
                cc_code = 'PP';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_paypal.png");
                break;
            case 'SP_C':
                cc_code = 'SP';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pagos_en_efectivo.png");
                break;
            case 'SP_I':
                cc_code = 'SP';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_banca_por_internet.png");
                break;
            case 'SP_E':
                cc_code = 'SP';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pagos_internacionales.png");
                break;
            case 'PE':
                cc_code = 'PE';
                $("#pagoefectivo").html('');
                $("#pagoefectivo").append("<b>Depósitos en efectivo</b>-En Cualquier agente o agencia autorizada a nivel nacional a la cuenta de Pago efectivo <a href='https://cip.pagoefectivo.pe/CNT/QueEsPagoEfectivo.aspx' target='blank'>¿Como Funciona?</a>");
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pe_de.png");
                break;
            case 'PEB':
                cc_code = 'PE';
                $("#pagoefectivo").html('');
                $("#pagoefectivo").append("<b>Paga en BBVA, BCP, Interbank, Scotiabank, BanBif, Caja Arequipa, a través de la banca por internet o banca móvil en la opción de pago de servicios. <a href='https://www.youtube.com/watch?v=oRbpV9mbSuc' target='blank'>¿Como Funciona?</a>");
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pe_tb.png");
                break;
        }
        MostrarInputCodigoDescuento(cc_code);
    });

    var MostrarInputCodigoDescuento = function (cc_code) {
        validos = $("#cc_codes_validos_desc").val();

        if (typeof validos != 'undefined') {
            var array_card_validas = validos.split(',');
            metodo_bool = $.inArray(cc_code, array_card_validas);
            if (metodo_bool >= 0) {
                $("#bloque_desc").css("display", "block");
            }
        }
    }


    $("body").on("click", "#btn_aplica_desc", function () {
        var data_obj_descuento;
        $('.aviso_cod_desc').remove();
        var desc_ingresado = $('#input_desc').val();
        var msg;
        var tipo_res;

        if (desc_ingresado === '') {
            msg = 'No ingresó ningún código';
            tipo_res = 'alert alert-warning';
        }
        $.post("Booking2/GetCodigoDescuento", { cod_desc: desc_ingresado }, function (data) {

            data_obj_descuento = data;
            if (data_obj_descuento === 'FALSE') {
                msg = 'El código ingresado no es válido.';
                tipo_res = 'alert alert-danger';
            } else {
                var total_pagar_con_desc = $('#TotalAplicaDesc').val();
                desc_data = data_obj_descuento.split('|');
                var codigo_descuento = desc_data[0];
                var monto = desc_data[1];
                var id_descuento = desc_data[2];
                msg = 'Código aplicado!';
                tipo_res = 'alert alert-success';
                var precio_total_establecido = $('.precio_total').text();
                if (!descuento_aplicado) {
                    $('.precio_total').text('');
                    $('.precio_total').append("<del>" + precio_total_establecido + "</del>");
                    $('.precio_total').after("<h1 class=\"text-right\"><b>$" + total_pagar_con_desc + "</b></h1>");
                    var html_input_desc = "<input type=\"hidden\" name=\"cod_descuento\" id=\"data_descuento\" value=" + codigo_descuento + ">";
                    var html_input_iddesc = "<input type=\"hidden\" name=\"id_descuento\" id=\"id_descuento\" value=" + id_descuento + ">";
                    var html_input_porcent_desc = "<input type=\"hidden\" name=\"porcentaje_descuento\" id=\"porcentaje_descuento\" value=" + monto + ">";
                    var html_input_precio_sin_desc = "<input type=\"hidden\" name=\"precio_total_sin_descuento\" id=\"precio_total_sin_descuento\" value=" + precio_total_establecido + ">";
                    $('#TotalAplicaDesc').after(html_input_desc);
                    $('#TotalAplicaDesc').after(html_input_porcent_desc);
                    $('#TotalAplicaDesc').after(html_input_precio_sin_desc);
                    $('#TotalAplicaDesc').after(html_input_iddesc);
                    descuento_aplicado = true;
                }
            }
            var bloque_res_cod_desc = ObtenerDivMensajeResProcesoCodDesc(msg, tipo_res);
            $('#bloque_desc').after(bloque_res_cod_desc);
        });

    });
    var ObtenerDivMensajeResProcesoCodDesc = function (msg, tipo_res) {
        var bloque_msg = "<div class='" + tipo_res + " col-md-12 col-sm-12 aviso_cod_desc text-center' role=\"alert\">" + msg + "</div>";
        return bloque_msg;
    }

    var OcultarInputCodigoDescuento = function () {
        $("#bloque_desc").hide();
    }

    var validateEmail = function (email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }


    $("#email").blur(function () {
        email1 = $(this).val();

        validateEmail(email1);
        if (!(validateEmail(email1))) {
            Mensaje = 'Ingresar Correctamente Email';
            $('#TxtMsg').html(Mensaje);
            $('#v_modal_error').modal('show');
        }


    });

    $("#email2").blur(function () {

        var email2 = $(this).val();
        if (email1 !== email2) {
            Mensaje = 'Los correos no coincide';
            $('#TxtMsg').html(Mensaje);
            $('#v_modal_error').modal('show');
        }
    });

    $(".texto").bind('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $('#num-loc').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });



    $('#RUC').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });



    $('#RUC').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#num-loc2').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    $('#region').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#region2').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    //PROHIBIR COPIAR Y PEGAR
    $(".vacios").on('paste', function (e) {
        e.preventDefault();
    });

    $(".vacios").on('copy', function (e) {
        e.preventDefault();
    });



    $('#validacion_v').click(function (event) {

        var documento = $('.documento').val();


        if (documento === null) {
            Mensaje = 'Debes completar todos los campos';
            $('#TxtMsg').html(Mensaje);
            $('#v_modal_error').modal('show');
            event.preventDefault();
        }

        var bool = $('.vacios').toArray().some(function (el) {
            return $(el).val().length < 1;
        });
        var bool2 = $('.vacios_radio').toArray().some(function (el) {
            return !($(el).is(':checked'));
        });
        if (bool) {
            Mensaje = 'Debes completar todos los campos';
            $('#TxtMsg').html(Mensaje);
            $('#v_modal_error').modal('show');
            event.preventDefault();
        } else {
            if (bool2) {
                Mensaje = 'Debe Aceptar las condicciones ';
                $('#TxtMsg').html(Mensaje);
                $('#v_modal_error').modal('show');
                event.preventDefault();
            }

        }

    });


});
function mayus(e) {
    e.value = e.value.toUpperCase();
}