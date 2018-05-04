function AjaxManager(){}

AjaxManager.prototype.getAjaxObject = 
	function(){
		var xmlHttp = null;
		try { 
			xmlHttp = new XMLHttpRequest(); 
		} catch (e) {
			try { 
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); //IE (recent versions)
			} catch (e) {
				try { 
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); //IE (older versions)
				} catch (e) {
					xmlHttp = null; 
				}
			}
		}
		return xmlHttp;
	}

AjaxManager.prototype.performAjaxRequest = 
	function(method, url, isAsync, dataToSend, responseFunction){
		var xmlHttp = this.getAjaxObject();
		if (xmlHttp === null){
			window.alert("Your browser does not support AJAX!"); // set error function
			return;
		}
		
		//alert("Metodo: "+method+" URL: "+url+" isAsync: "+isAsync+" dataToSend: "+dataToSend);
		xmlHttp.open(method, url, isAsync);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function (){
			if (xmlHttp.readyState == 4){
				//console.log(xmlHttp.responseText);
				//var data = JSON.parse(xmlHttp.responseText);
				//alert(xmlHttp.responseText);
				responseFunction(xmlHttp.responseText);
			}
		}
		xmlHttp.send(dataToSend);
}

AJAX = new AjaxManager();