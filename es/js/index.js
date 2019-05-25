
		function mayusculas(txt){
		  var checkOK = "ABCDEFGHIJKLMNÃ‘OPQRSTUVWXYZ ";
		  txt.value=txt.value.toUpperCase(); 
		  var checkStr = txt.value;
		  var allValid = true; 
		  aux="";
		  for (i = 0; i < checkStr.length; i++) 
		  {
			ch = checkStr.charAt(i); 
			for (j = 0; j < checkOK.length; j++)
				if (ch == checkOK.charAt(j))
					if(ch=="Ã‘")
						aux=aux+"N";
					else
						aux=aux+ch;
		  }
		  txt.value=aux;
		}
	
		function alfanumerico(txt){
		  var checkOK = "ABCDEFGHIJKLMNÃ‘OPQRSTUVWXYZ1234567890. ";
		  txt.value=txt.value.toUpperCase(); 
		  var checkStr = txt.value;
		  var allValid = true; 
		  aux="";
		  for (i = 0; i < checkStr.length; i++) 
		  {
			ch = checkStr.charAt(i); 
			for (j = 0; j < checkOK.length; j++)
				if (ch == checkOK.charAt(j))
					if(ch=="Ã‘")
						aux=aux+"N";
					else
						aux=aux+ch;
		  }
		  txt.value=aux;
		}

		


		
		function asignaOrigen()
		{
			var origen=document.getElementById("desde").value;
			document.getElementById("codigoorigen").value=origen;
		}

		function asignaDestino()
		{
			var destino=document.getElementById("hasta").value;
			document.getElementById("codigodestino").value=destino;
		}
		
		function cargaOrigen()
		{
			var strUrl, comboOrigen, comboDestino, origen;
			comboOrigen=document.getElementById("desde");
			strUrl="&str=1";
			removeAllOptions(comboOrigen);
			doAjax('../lib/busca_origen.php',strUrl,"recojeOrigen", "get", "0");
			
			
		}
    	
		function recojeOrigen(txt)
		{
			var capturaCiudad=txt;
			var arrayCiudades= capturaCiudad.split(">");  
			var nroArray= arrayCiudades.length;
			var comboDestino=document.getElementById("desde");
			var i=0;

			addOption(comboDestino,"",0)
			for(i=0; i<(nroArray-1); i=i+1)
			{
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
			doAjax('../lib/busca_destino.php',strUrl,"cargaDestinoInicio", "get", "0");
		}
    	
		
		function cargaDestinoInicio(txt)
		{

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
			doAjax('../lib/busca_fecha.php',strUrl,"cargaFechaVuelo", "get", "0");
		}
		

		function cargaFechaVuelo(txt)
		{
			var captura=txt;
			var arrayFecha= captura.split("<>");  

			document.getElementById("from").value=arrayFecha[0];
			document.getElementById("to").value=arrayFecha[1];
		}

		
		function cargaDestino()
		{
//		alert("Hola Mundo");
                        
			asignaOrigen();
			
			var strUrl, comboOrigen, comboDestino, origen;
			comboOrigen=document.getElementById("desde");
			comboDestino=document.getElementById("hasta");
			origen=comboOrigen.value;
			strUrl="&origen=" + origen;
			document.getElementById("codigoorigen").value=origen;
			removeAllOptions(comboDestino);
			doAjax('../lib/busca_destino.php',strUrl,"recojeCiudad", "get", "0");

		}

		function recojeCiudad(txt)
		{
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
		
		function addOption(selectbox,text,value )
		{
			var optn = document.createElement("OPTION");
			optn.text = text;
			optn.value = value;
			selectbox.options.add(optn);
		}

		function removeAllOptions(selectbox)
		{
			var i;
			for(i=selectbox.options.length-1;i>=0;i--)
			{
				selectbox.remove(i);
			}
		}
		
		
		function cargaInfantes()
		{
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


		function Desactiva()
		{
			document.getElementById("id_fecha_retorno").style.display="none";
		}	
		
		function Activa2()
		{
			document.getElementById("id_fecha_retorno").style.display="inline";
		}

		function cargarPagina()
		{
			setTimeout("cargaOrigen()",1000);	
		}