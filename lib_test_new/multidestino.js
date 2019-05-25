function cargaOrigen(i)
{
        var strUrl, comboOrigen, comboDestino, origen;
        comboOrigen=document.getElementById("salida"+i);
        document.getElementById("indice").value=i;
        strUrl="&str=1";
        removeAllOptions(comboOrigen);
        doAjax('../lib/busca_origen.php',strUrl,"recojeOrigen", "get", "0");
}

function recojeOrigen(txt)
{
        var capturaCiudad=txt;
        var arrayCiudades= capturaCiudad.split(">");  
        var nroArray= arrayCiudades.length;
        var j = document.getElementById("indice").value;
//        alert(j);return false;
        var comboDestino=document.getElementById("salida"+j);
        var i=0;

        addOption(comboDestino,"SELECCIONE",0)
        for(i=0; i<(nroArray-1); i=i+1)
        {
                var datoAux=arrayCiudades[i];
                var arrayAux=datoAux.split(":");
                addOption(comboDestino,arrayAux[1],arrayAux[0] )
        }


//        var cantidad = comboDestino.length;
//        for (i = 0; i < cantidad; i++) {
//            if (comboDestino[i].value == "LIM") {
//                comboDestino[i].selected = true;
//            }
//        }
}

function asignaOrigen(i)
{
        var origen=document.getElementById("salida"+i).value;
        document.getElementById("origen"+i).value=origen;
}


function cargaDestinoMultidestino(i)
{
        asignaOrigen(i);
        var strUrl, comboOrigen, comboDestino, origen;
        comboOrigen=document.getElementById("salida"+i);
        comboDestino=document.getElementById("llegada"+i);
        origen=comboOrigen.value;
        strUrl="&origen=" + origen;
        document.getElementById("origen"+i).value=origen;
        document.getElementById("indice").value=i;
        removeAllOptions(comboDestino);
        doAjax('../lib/busca_destino.php',strUrl,"recojeCiudad", "get", "0");
}

function removeAllOptions(selectbox)
{
        var i;
        for(i=selectbox.options.length-1;i>=0;i--)
        {
                selectbox.remove(i);
        }
}
                
function recojeCiudad(txt)
{       
        var capturaCiudad=txt;
        var arrayCiudades= capturaCiudad.split(">");  
        var nroArray= arrayCiudades.length;
        var j = document.getElementById("indice").value;
        var comboDestino=document.getElementById("llegada"+j);
        var i=0;
        addOption(comboDestino,"SELECCIONAR",0)
        for(i=0; i<(nroArray-1); i=i+1)
        {
                var datoAux=arrayCiudades[i];
                var arrayAux=datoAux.split(":");
                addOption(comboDestino,arrayAux[1],arrayAux[0] )
        }
}

function addOption(selectbox,text,value )
{
        var optn = document.createElement("OPTION");
        optn.text = text;
        optn.value = value;
        selectbox.options.add(optn);
}