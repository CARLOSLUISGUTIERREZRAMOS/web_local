$(function () {

    //<editor-fold defaultstate="collapsed" desc="VER BLOQUE MAIN PROGRAMACION DEFAULT">
//    var myCalendar;
//    var today;
//
//    $(window).on("load", function () {
//        doOnLoad();
//    });
//
//    function doOnLoad() {
//        myCalendar = new dhtmlXCalendarObject(["date_from", "date_to"]);
//        myCalendar.setDateFormat("%d/%m/%Y")
//        today = myCalendar.getDate(true);
//        myCalendar.hideTime();
//        if (document.getElementById("date_from") && document.getElementById("date_to")) {
//            byId("date_from").value = today;
//            byId("date_to").value = today;
//        }
//    }
//
//    var setSens = function (id, k) {
//        // update range
//        if (k == "min") {
//            myCalendar.setSensitiveRange(byId(id).value, null);
//        } else {
//            myCalendar.setSensitiveRange(null, byId(id).value);
//        }
//    }
//
//    var CapturarDiaTo = function () {
//        myCalendar.attachEvent("onClick", function (d) {
//            byId("date_to").value = myCalendar.getFormatedDate(null, d);
//        });
//    }
//
//    var ShowCalendarTo = function () {
//        myCalendar.attachEvent("onClick", function () {
//            setSens('date_from', 'min');
//            if (!byId('customRadioInline1').checked) {
//                myCalendar.show('date_to');
//                myCalendar.attachEvent("onClick", function () {
//                    myCalendar.hide();
//                });
//            }
//        });
//    }

//    $('#from').click(function () {
//        setFrom();
//        ShowCalendarTo();
//        CapturarDiaTo();
//    });
//    $('#to').click(function () {
//        setSens('date_from', 'min');
//    });
//    $('#customRadioInline1').click(function () {
//        show1();
//    });
//    $('#customRadioInline2').click(function () {
//        show2();
//    });
//    var setFrom = function () {
//        myCalendar.setSensitiveRange(today, null);
//    }
//    var byId = function (id) {
//        return document.getElementById(id);
//    }



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

//    function show1() {
//        document.getElementById('twoway').style.display = 'none';
//        document.getElementById('oneway').style.display = 'block';
//    }
//
//    function show2() {
//        document.getElementById('oneway').style.display = 'none';
//        document.getElementById('twoway').style.display = 'block';
//    }

//</editor-fold>



    $('[data-toggle="popover"]').popover('hide');
    $('.SumAdl').popover("hide");

    /*Intruccion para que el tipo de vuelo este siempre marcado por defautl en ida y vuelta*/
    $('#customRadioInline2').prop('checked', true);


    $('.btn_submit').click(function (event) {
        event.preventDefault();
        origen = $('#desde').val();
        destino = $('#hasta').val();
        var CantPax = parseInt($('#tld3').val()) + parseInt($('#tld1').val()) + parseInt($('#tld2').val());


        if ((destino === null || destino == '0') || origen === null) {
            $('#TxtMsg').html('La ciudad de origen y destino deben estar establecidos.');
            $('#tld3').popover("hide");
            $('#v_modal_error').modal({
                show: true,
                keyboard: false
            });
        } else if (CantPax > 9) {
            $('#TxtMsg').html('La cantidad de pasajeros no puede ser mayor de nueve');
            $('#tld3').popover("hide");
            $('#v_modal_error').modal('show');
        } else if (CantPax < 1) {
            $('#TxtMsg').html('Debes elegir por lo menos un  pasajero.');
            $('#tld3').popover("hide");
            $('#v_modal_error').modal('show');
        } else {
            $('#frm_paso1').submit();
        }
    });

    $('.SumAdl').click(function () {
//         $('.SumAdl').popover("hide");

        var cant_adl = parseInt($('#tld3').val());
        var ninos = parseInt($('#tld1').val());
        var bebes = parseInt($('#tld2').val());
        var cant_pax = cant_adl + ninos + bebes;
        if (cant_pax > 9) {
            $('#tld3').popover('show');
        } else {
            $('#tld3').popover("hide");
        }
    });




});