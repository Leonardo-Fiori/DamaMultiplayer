/* FUNZIONI DI RISPOSTA CLIENT */

function isJson(str){
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function newDataReceived(data){
	// Controllo che il messaggio ricevuto sia in json,
	// altrimenti lo tratto come una stringa.
	var Json = isJson(data);
	var out = null;
	var resp = null;
	if(Json){
		out = JSON.parse(data);
		resp = out[0];
	}
	else{
		resp = data;
	}

	if(resp == "Move"){
		dama.spostaPedina(out[1],out[2]);
		mioTurno=true;
		checkNewDataInterval(false);
		alert("E' il tuo turno!");
		return true;
	}
	else if(resp == "NoNewData"){
		//alert("In attesa che il giocatore faccia una mossa...");
		return true;
	}
	else if(resp == "YouWon"){
		alert("Hai vinto!");
		stop();
		return true;
	}
	else if(resp == "Error"){
		alert("Errore: "+resp[1]);
		stop();
		return false;
	}
	else{
		alert("Errore sconosciuto!");
		stop();
		return false;
	}
}

function newDataSent(data){
	if(data=="Sent"){
		alert("Dati inviati...");
		return true;
	}
	else if(data=="Error"){
		alert("Errore!");
		stop();
		return false;
	}
	else if(data=="NotInMatch"){
		alert("Non sei in un match!");
	}
	else{
		return false;
	}
}

function matchStopped(data){
	alert("Hai perso!");
	return true;
}

/* FUNZIONI DI INVIO E RICEZIONE AL SERVER */

function checkNewMatchData(){
	AJAX.performAjaxRequest("POST","./php/ajax/matchDataDownloader.php",true,null,newDataReceived);
}

function sendNewMatchData(da,a){
	stringToSend = "movefrom="+da+"&moveto="+a;
	AJAX.performAjaxRequest("POST","./php/ajax/matchDataUpdater.php",true,stringToSend,newDataSent);
}

function sendStopMatch(){
	AJAX.performAjaxRequest("POST","./php/ajax/matchStopper.php",true,null,matchStopped);
}

/* CLOCK DI CONTROLLO NUOVI DATI */

var nmdIntvl = null;
function checkNewDataInterval(control){
	if(control==true && nmdIntvl == null) 
		nmdIntvl = setInterval(checkNewMatchData, 1000);
	else{ 
		clearInterval(nmdIntvl);
		nmdIntvl = null;
	}
}