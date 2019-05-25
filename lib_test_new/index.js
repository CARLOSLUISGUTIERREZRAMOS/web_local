	$(function () {
		ciudad=	[
						{
							"codigo" : "CIX",
							"nombre" : "CHICLAYO",
						},
						{
							"codigo" : "CJA",
							"nombre" : "CAJAMARCA",
						},
						{
							"codigo" : "CUZ",
							"nombre" : "CUZCO",
						},
						{
							"codigo" : "IQT",
							"nombre" : "IQUITOS",
						},
						{
							"codigo" : "LIM",
							"nombre" : "LIMA",
						},
						{
							"codigo" : "PCL",
							"nombre" : "PUCALLPA",
						},
						{
							"codigo" : "TPP",
							"nombre" : "TARAPOTO",
						}
					];

		rutas = [
						{
							"id" : 0000000001,
							"ciudad_origen_codigo" : "LIM",
							"ciudad_destino_codigo" : "CUZ",
							"estado" : "1"
						},
						{
							"id" : 0000000002,
							"ciudad_origen_codigo" : "LIM",
							"ciudad_destino_codigo" : "TPP",
							"estado" : "1"
						},
						{
							"id" : 0000000003,
							"ciudad_origen_codigo" : "LIM",
							"ciudad_destino_codigo" : "PCL",
							"estado" : "1"
						},
						{
							"id" : 0000000004,
							"ciudad_origen_codigo" : "LIM",
							"ciudad_destino_codigo" : "IQT",
							"estado" : "1"
						},
						{
							"id" : 0000000005,
							"ciudad_origen_codigo" : "CUZ",
							"ciudad_destino_codigo" : "LIM",
							"estado" : "1"
						},
						{
							"id" : 0000000006,
							"ciudad_origen_codigo" : "TPP",
							"ciudad_destino_codigo" : "LIM",
							"estado" : "1"
						},
						{
							"id" : 0000000007,
							"ciudad_origen_codigo" : "TPP",
							"ciudad_destino_codigo" : "IQT",
							"estado" : "1"
						},
						{
							"id" : 0000000008,
							"ciudad_origen_codigo" : "PCL",
							"ciudad_destino_codigo" : "LIM",
							"estado" : "1"
						},
						{
							"id" : 0000000009,
							"ciudad_origen_codigo" : "PCL",
							"ciudad_destino_codigo" : "IQT",
							"estado" : "1"
						},
						{
							"id" : 0000000010,
							"ciudad_origen_codigo" : "IQT",
							"ciudad_destino_codigo" : "LIM",
							"estado" : "1"
						},
						{
							"id" : 0000000011,
							"ciudad_origen_codigo" : "IQT",
							"ciudad_destino_codigo" : "TPP",
							"estado" : "1"
						},
						{
							"id" : 0000000012,
							"ciudad_origen_codigo" : "IQT",
							"ciudad_destino_codigo" : "PCL",
							"estado" : "1"
						},
						{
							"id" : 0000000013,
							"ciudad_origen_codigo" : "LIM",
							"ciudad_destino_codigo" : "CIX",
							"estado" : "1"
						},
						{
							"id" : 0000000014,
							"ciudad_origen_codigo" : "CIX",
							"ciudad_destino_codigo" : "LIM",
							"estado" : "1"
						},
						{
							"id" : 0000000015,
							"ciudad_origen_codigo" : "LIM",
							"ciudad_destino_codigo" : "CJA",
							"estado" : "1"
						},
						{
							"id" : 0000000016,
							"ciudad_origen_codigo" : "CJA",
							"ciudad_destino_codigo" : "LIM",
							"estado" : "1"
						}
					];
	})
	function mayusculas(txt){
		var checkOK = "ABCDEFGHIJKLMNÃƒâ€˜OPQRSTUVWXYZ ";
		txt.value=txt.value.toUpperCase(); 
		var checkStr = txt.value;
		var allValid = true; 
		aux="";
		for (i = 0; i < checkStr.length; i++){
			ch = checkStr.charAt(i); 
			for (j = 0; j < checkOK.length; j++)
				if (ch == checkOK.charAt(j))
					if(ch=="Ãƒâ€˜")
						aux=aux+"N";
					else
						aux=aux+ch;
		}
		txt.value=aux;
	}

	function alfanumerico(txt){
		var checkOK = "ABCDEFGHIJKLMNÃƒâ€˜OPQRSTUVWXYZ1234567890. ";
		txt.value=txt.value.toUpperCase(); 
		var checkStr = txt.value;
		var allValid = true; 
		aux="";
		for (i = 0; i < checkStr.length; i++){
			ch = checkStr.charAt(i); 
			for (j = 0; j < checkOK.length; j++)
				if (ch == checkOK.charAt(j))
					if(ch=="Ãƒâ€˜")
						aux=aux+"N";
					else
						aux=aux+ch;
		}
		txt.value=aux;
	}
	
	function asignaOrigen(){
		var origen=document.getElementById("desde").value;
		document.getElementById("codigoorigen").value=origen;
	}

	function asignaDestino(){
		var destino=document.getElementById("hasta").value;
		document.getElementById("codigodestino").value=destino;
	}
	
	// function cargaOrigen(){
	// 	var strUrl, comboOrigen, comboDestino, origen;
	// 	comboOrigen=document.getElementById("desde");
	// 	strUrl="&str=1";
	// 	removeAllOptions(comboOrigen);
	// 	doAjax('../lib_test_new/busca_origen.php',strUrl,"recojeOrigen", "get", "0");
	// }

	function dataCiudad() {
		$("select[name=origen]").empty();
		$.each(ciudad,function(index,element){
			$("select[name=origen]").append($('<option>', {value: element.codigo, text: element.nombre}));
		});
		$("select[name=origen]").val('LIM');
		cargarDataDestino('LIM');
		$("#codigoorigen").val('LIM');
	}

	function cargarDataDestino(id) {
		$("select[name=destino]").empty();
		$("select[name=destino]").append('<option value="">SELECCIONAR</option>');
		var resultados=rutas.filter(function(resultado) {
			return resultado.ciudad_origen_codigo==id;
		});
		if (resultados.length>0) {
			$.each(resultados,function(index,element){
				var nombre=obtenerNombreCuidad(element.ciudad_destino_codigo);
				$("select[name=destino]").append($('<option>', {value: element.ciudad_destino_codigo, text: nombre}));
			});
		}
	}

	function obtenerNombreCuidad(codigo) {
		var resultado=ciudad.filter(function(objeto) {
			return objeto.codigo==codigo;
		});
		return resultado[0].nombre;
	}

	$(document).on('change','select[name=origen]',function (arg) {
		cargarDataDestino(this.value);
		$("#codigoorigen").val(this.value);
	});
	
	function recojeOrigen(txt){
		var capturaCiudad=txt;
		var arrayCiudades= capturaCiudad.split(">");  
		var nroArray= arrayCiudades.length;
		var comboDestino=document.getElementById("desde");
		var i=0;

		addOption(comboDestino,"",0)
		for(i=0; i<(nroArray-1); i=i+1){
			var datoAux=arrayCiudades[i];
			var arrayAux=datoAux.split(":");
			addOption(comboDestino,arrayAux[1],arrayAux[0] )
		}
		
	   	var cantidad = comboDestino.length;
	   	for (i = 0; i < cantidad; i++) {
			if (comboDestino[i].value == "LIM") {
				comboDestino[i].selected = true;
			}   
	   }

		var comboDestino=document.getElementById("hasta");
		strUrl="&origen=LIM";
		document.getElementById("codigoorigen").value="LIM";
		removeAllOptions(comboDestino);
		doAjax('../lib_test_new/busca_destino.php',strUrl,"cargaDestinoInicio", "get", "0");
	}
	
	
	function cargaDestinoInicio(txt){

		var capturaCiudad=txt;
		var arrayCiudades= capturaCiudad.split(">");  
		var nroArray= arrayCiudades.length;
		var comboDestino=document.getElementById("hasta");
		var i=0;

		addOption(comboDestino,"SELECCIONAR",0)
		for(i=0; i<(nroArray-1); i=i+1)
		{
			var datoAux=arrayCiudades[i];
			var arrayAux=datoAux.split(":");
			addOption(comboDestino,arrayAux[1],arrayAux[0] )
		}		
		
		    var cantidad = comboDestino.length;
// 		    for (i = 0; i < cantidad; i++) 
//			{
// 			   if (comboDestino[i].value == "CUZ") 
//			   {
// 				 comboDestino[i].selected = true;
// 			   }   
// 		    }
		
                    document.getElementById("codigodestino").value="";
//			document.getElementById("codigodestino").value="CUZ";
		doAjax('../lib_test/busca_fecha.php',strUrl,"cargaFechaVuelo", "get", "0");
	}
	

	function cargaFechaVuelo(txt){
		var captura=txt;
		var arrayFecha= captura.split("<>");  

		document.getElementById("from").value=arrayFecha[0];
		document.getElementById("to").value=arrayFecha[1];
	}

	
	function cargaDestino(){
		asignaOrigen();
		
		var strUrl, comboOrigen, comboDestino, origen;
		comboOrigen=document.getElementById("desde");
		comboDestino=document.getElementById("hasta");
		origen=comboOrigen.value;
		strUrl="&origen=" + origen;
		document.getElementById("codigoorigen").value=origen;
//                        console.log(origen);
		removeAllOptions(comboDestino);
		doAjax('../lib_test/busca_destino.php',strUrl,"recojeCiudad", "get", "0");
	}

	function recojeCiudad(txt){
		var capturaCiudad=txt;
		var arrayCiudades= capturaCiudad.split(">");  
		var nroArray= arrayCiudades.length;
		var comboDestino=document.getElementById("hasta");
		var i=0;

		addOption(comboDestino,"SELECCIONAR",0)
		for(i=0; i<(nroArray-1); i=i+1)
		{
			var datoAux=arrayCiudades[i];
			var arrayAux=datoAux.split(":");
			addOption(comboDestino,arrayAux[1],arrayAux[0] )
		}
	}
	
	function addOption(selectbox,text,value ){
		var optn = document.createElement("OPTION");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
	}

	function removeAllOptions(selectbox){
		var i;
		for(i=selectbox.options.length-1;i>=0;i--)
		{
			selectbox.remove(i);
		}
	}
	
	function cargaInfantes(){
		var comboAdulto=document.getElementById("tld3");
		var comboInfantes=document.getElementById("tld2");

		var arrayAdultos=arrayAux=(comboAdulto.value).split(" ");
		var nroAdultos=arrayAdultos[0];
		var nroInfantes=0;			
		
		if(nroAdultos<5) nroInfantes=nroAdultos;			
		else nroInfantes=4;
		
		var i=0;
		removeAllOptions(comboInfantes);
		for(i=0; i<=(nroInfantes); i=i+1)
		{
			if(i==1)
				addOption(comboInfantes,i+" Bebe",i+" Bebe");
			else
				addOption(comboInfantes,i+" Bebes",i+" Bebes");
		} 				
	}


	function Desactiva(){
		document.getElementById("id_fecha_retorno").style.display="none";
	}	
	
	function Activa2(){
		document.getElementById("id_fecha_retorno").style.display="inline";
	}

	function cargarPagina(){
		setTimeout("dataCiudad()",1000);	
	}
            
    function GuardaPasajero(){
        $ ("#GuardaPasajero").click(function(){
            var strUrl, nombre, apellido, email;
			nombre=document.getElementById("nombre");
			apellido=document.getElementById("apellido");
			email=document.getElementById("email");
            strUrl="&nombre=" + nombre+"&apellido=" + apellido+"&email="+ email;
			doAjax('../lib_test/inserta_pasajero.php', strUrl, "test", "get", "0");
        });
    }

    function test(data){
        console.log(data);
    }