$(function () {
    var documento;
    var email1;
    $("body").on("change", "#select_cards", function () {

        var tarjeta_set = $(this).val();
        switch (tarjeta_set) {
            case 'TC_V':
//                $("#img_cards").removeClass( "w-70 w-100" );
//                $("#img_cards").addClass("w-100");
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_visa_opc2.png");
                break;
            case 'TC_D':
//                $("#img_cards").removeClass( "w-70 w-100" );
//                $("#img_cards").addClass("w-100");
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_diners.png");
                break;
            case 'PP':
//                $("#img_cards").addClass('w-70');
//                $("#img_cards").removeClass("w-100 w-70");
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_paypal.png");
                break;
            case 'SP_C':
//                 $("#img_cards").removeClass("w-100 w-70");
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pagos_en_efectivo.png");
                break;
            case 'SP_I':
//                 $("#img_cards").removeClass("w-100 w-70");
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_banca_por_internet.png");
                break;
            case 'SP_E':
//                 $("#img_cards").removeClass("w-100 w-70");
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pagos_internacionales.png");
                break;
            case 'PE':
                $("#pagoefectivo").html('');
                $("#pagoefectivo").append("<b>Depósitos en efectivo</b>-En Cualquier agente o agencia autorizada a nivel nacional a la cuenta de Pago efectivo <a href='https://cip.pagoefectivo.pe/CNT/QueEsPagoEfectivo.aspx' target='blank'>¿Como Funciona?</a>");
//                 $("#img_cards").removeClass("w-100 w-70");
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pe_de.png");
                break;
            case 'PEB':
                $("#pagoefectivo").html('');
                $("#pagoefectivo").append("<b>Paga en BBVA, BCP, Interbank, Scotiabank, BanBif, Caja Arequipa, a través de la banca por internet o banca móvil en la opción de pago de servicios. <a href='https://www.youtube.com/watch?v=oRbpV9mbSuc' target='blank'>¿Como Funciona?</a>");
//                 $("#img_cards").removeClass("w-100 w-70");
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pe_tb.png");
                break;
        }

    });

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