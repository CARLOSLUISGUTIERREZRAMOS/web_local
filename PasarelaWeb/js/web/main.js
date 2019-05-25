$(function () {

    //<editor-fold defaultstate="collapsed" desc="VER BLOQUE MAIN PROGRAMACION DEFAULT">
    var myCalendar;
    var today;

    $(window).on("load", function () {
        doOnLoad();
    });

    function doOnLoad() {
        myCalendar = new dhtmlXCalendarObject(["date_from", "date_to"]);
        myCalendar.setDateFormat("%d/%m/%Y")
        today = myCalendar.getDate(true);
        myCalendar.hideTime();
        if (document.getElementById("date_from") && document.getElementById("date_to")) {
            byId("date_from").value = today;
            byId("date_to").value = today;
        }
    }

    var setSens = function (id, k) {
        // update range
        if (k == "min") {
            myCalendar.setSensitiveRange(byId(id).value, null);
        } else {
            myCalendar.setSensitiveRange(null, byId(id).value);
        }
    }

    var CapturarDiaTo = function () {
        myCalendar.attachEvent("onClick", function (d) {
            byId("date_to").value = myCalendar.getFormatedDate(null, d);
        });
    }

    var ShowCalendarTo = function () {
        myCalendar.attachEvent("onClick", function () {
            setSens('date_from', 'min');
            if (!byId('customRadioInline1').checked) {
                myCalendar.show('date_to');
                myCalendar.attachEvent("onClick", function () {
                    myCalendar.hide();
                });
            }
        });
    }

    $('#date_from').click(function () {
        setFrom();
        ShowCalendarTo();
        CapturarDiaTo();
    });
    $('#date_to').click(function () {
        setSens('date_from', 'min');
    });
    $('#customRadioInline1').click(function () {
        show1();
    });
    $('#customRadioInline2').click(function () {
        show2();
    });

    var byId = function (id) {
        return document.getElementById(id);
    }

    var setFrom = function () {
        myCalendar.setSensitiveRange(today, null);
    }

    $(".mod").on("click", function () {
        var $button = $(this);
        var oldValue = $button.parent().parent().find("input").val();
        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().parent().find("input").val(newVal);
    });

    function show1() {
        document.getElementById('twoway').style.display = 'none';
        document.getElementById('oneway').style.display = 'block';
    }

    function show2() {
        document.getElementById('oneway').style.display = 'none';
        document.getElementById('twoway').style.display = 'block';
    }

//</editor-fold>



    $('[data-toggle="popover"]').popover('hide');
    $('.SumAdl').popover("hide");

    /*Intruccion para que el tipo de vuelo este siempre marcado por defautl en ida y vuelta*/
    $('#customRadioInline2').prop('checked', true);

    $('#origen').on('change', function () {
        CargaDestino();
        origen = $("#origen option:selected").text();
        $("#hidd_name_ciu_orig").val(origen);
    });
    $('#ciudad_destino').on('change', function () {
        var destino = $("#ciudad_destino option:selected").text();
        $("#hidd_name_ciu_dest").val(destino);

    });

    $('.btn_submit').click(function (event) {
        event.preventDefault();
        destino = $('#ciudad_destino').val();
        origen = $('#origen').val();
        var CantPax = parseInt($('#adultos').val()) + parseInt($('#ninos').val()) + parseInt($('#bebes').val());


        if (destino === null || origen === null) {
            $('#TxtMsg').html('La ciudad de origen y destino deben estar establecidos.');
            $('#adultos').popover("hide");
            $('#v_modal_error').modal({
                show: true,
                keyboard: false
            });
        } else if (CantPax > 9) {
            $('#TxtMsg').html('La cantidad de pasajeros no puede ser mayor de nueve');
            $('#adultos').popover("hide");
            $('#v_modal_error').modal('show');
        } else if (CantPax < 1) {
            $('#TxtMsg').html('Debes elegir por lo menos un  pasajero.');
            $('#adultos').popover("hide");
            $('#v_modal_error').modal('show');
        } else {
            $('#FormMain').submit();
        }
    });

    $('.SumAdl').click(function () {
//         $('.SumAdl').popover("hide");

        var cant_adl = parseInt($('#adultos').val());
        var ninos = parseInt($('#ninos').val());
        var bebes = parseInt($('#bebes').val());
        var cant_pax = cant_adl + ninos + bebes;
        if (cant_pax > 9) {
            $('#adultos').popover('show');
        } else {
            $('#adultos').popover("hide");
        }
    });

    var CargaDestino = function () {
        var ciudad_origen = $('#origen').val();
        origen = $("#origen option:selected").text();
        $("#hidd_name_ciu_orig").val(origen);
        $.ajax({
            type: "POST",
            url: '/new_web_2019/Main/ObtenerRutas',
            data: 'ciudad_origen=' + ciudad_origen,
            success: function (data)
            {
                $('#ciudad_destino').empty();
                rutas = jQuery.parseJSON(data);

                $('#ciudad_destino').append('<option disabled selected value>SELECCIONE</option>');
                jQuery.each(rutas, function (i, val) {
                    $('#ciudad_destino').append($('<option>', {value: val.codigo, text: val.nombre}));
                });
            }
        });
    }

    CargaDestino();
});