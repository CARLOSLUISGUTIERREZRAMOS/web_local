	function createREQ() {
		try {
	    	req = new XMLHttpRequest(); /* p.e. Firefox */
	    }
	    catch(err1) {
	    	try {
	       		req = new ActiveXObject('Msxml2.XMLHTTP'); /* algunas versiones IE */
	       	} 
	       	catch (err2) {
	        	try {
	        		req = new ActiveXObject("Microsoft.XMLHTTP"); /* algunas versiones IE */
	         	}
	         	catch (err3) {
	          		req = false;
	         	}
	       	}
	    }
	    return req;
	}

	function requestGET(url, query, req) {
		myRand=parseInt(Math.random()*99999999);
		req.open("GET",url+'?'+query+'&rand='+myRand,true);
		req.send(null);
	}

	function requestPOST(url, query, req) {
		req.open("POST", url,true);
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send(query);
	}

	function doCallback(callback,item) {
		eval(callback + '(item)');
	}

	function doAjax(url,query,callback,reqtype,getxml) {
		// crea la instancia del objeto XMLHTTPRequest 
		var myreq = createREQ();
		myreq.onreadystatechange = function() {
			if(myreq.readyState == 4) {
			   	if(myreq.status == 200) {
			    	var item = myreq.responseText;
			      	if(getxml==1) {
			        	item = myreq.responseXML;
			      	}
			      	doCallback(callback, item);
			    }
		  	}
		}
		if(reqtype=='post') {
			requestPOST(url,query,myreq);
		} 
		else {
			requestGET(url,query,myreq);
		}
	} 

	function creaAjax() {
		var req;
		try {
			req = new XMLHttpRequest();
		}
		catch(err1) {
			try {
				req = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (err2) {
				try {
					req = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (err3) {
					req = false;
				}
			}
		}
		return req;
	}
			
	oAjax = creaAjax();
	oAjax2 = creaAjax();
	oAjax3 = creaAjax();
	oAjax4 = creaAjax();


	function fAjax(url,vars,capa){
		myRand = parseInt(Math.random()*999999999999999);
		var geturl = url +"?rand=" + myRand + vars; 
		oAjax.open("GET", geturl, true);
		capa_rpta = capa;
		oAjax.onreadystatechange = rAjax;
		oAjax.send(null);
	}

	function rAjax() {
		if (oAjax.readyState == 4) {
			if(oAjax.status == 200) {
				var miTexto = oAjax.responseText;
				document.getElementById(capa_rpta).innerHTML = (miTexto);
			}else{
				document.getElementById(capa_rpta).innerHTML = "cambiando";
			}
		}
	}
		

