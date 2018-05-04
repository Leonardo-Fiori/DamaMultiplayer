function Damiera(){
	// L'array posizioniPedine mantiene lo stato della partita.
	// ogni valore che assume ha un significato:
	// 0 = casella vuota (bianca, di gioco).
	// 5 = casella vuota (nera, non utilizzabile).
	// 1 = casella occupata da pedina bianca (nel gioco si vede rossa).
	// 2 = casella occupata da pedina nera (nel gioco si vede grigio scura).
	// 3 = casella occupata da dama bianca.
	// 4 = casella occupata da dama nera.
	this.posizioniPedine = new Array(2,5,2,5,2,5,2,5, 
									 5,2,5,2,5,2,5,2,
									 2,5,2,5,2,5,2,5,
									 5,0,5,0,5,0,5,0,
									 0,5,0,5,0,5,0,5,
									 5,1,5,1,5,1,5,1,
									 1,5,1,5,1,5,1,5,
									 5,1,5,1,5,1,5,1);
}

// Funzione di utilità usata dalla disegna caselle per
// creare la damiera nel suo stato iniziale.
Damiera.prototype.creaCasella = function(tipo,id){
	var casella = document.createElement("div");
	var img = document.createElement("img");
	
	if(tipo == "casellaGrigia"){ img.setAttribute("src","./css/img/casellaGrigia.png"); }
	else if(tipo == "casellaNera"){ img.setAttribute("src","./css/img/casellaNera.png"); }
	else if(tipo == "pedinaGrigia"){ img.setAttribute("src","./css/img/pedinaRossa.png"); }
	else if(tipo == "pedinaRossa"){ img.setAttribute("src","./css/img/pedinaRossa.png");}
	else{ return; }

	img.setAttribute("onclick","controlPawn(this)");
	img.setAttribute("alt","Casella");
	casella.setAttribute("class","casella");
	img.setAttribute("id",id);
	img.setAttribute("id",id);
	casella.appendChild(img);
	
	return casella;
}

// Disegna le caselle nella loro posizione iniziale inalterata.
// Per aggiornare lo stato delle caselle verrà usata la disegnaPedine,
// che modificherà lo stato solamente delle caselle di gioco (bianche).
Damiera.prototype.disegnaCaselle = function(){
	var damiera = document.createElement("div");
	damiera.setAttribute("id","damiera");
	damiera.setAttribute("class","damiera");
	
	for(var i = 0; i < 8; i++){
		var riga = document.createElement("div");
		riga.setAttribute("class","riga");
		for(var j = 0; j < 8; j++){
			var idCasella = (8*i)+j;
			var casella = null;
			if(this.posizioniPedine[idCasella]==0) casella = this.creaCasella("casellaGrigia",idCasella);
			else if(this.posizioniPedine[idCasella]==5) casella = this.creaCasella("casellaNera",idCasella);
			else if(this.posizioniPedine[idCasella]==1) casella = this.creaCasella("pedinaRossa",idCasella);
			else if(this.posizioniPedine[idCasella]==2) casella = this.creaCasella("pedinaGrigia",idCasella);
			riga.appendChild(casella);
		}
		damiera.appendChild(riga);
	}
	
	document.getElementById("playfield").appendChild(damiera);

	alphaIntvl = setInterval(increaseBoardAlpha, 10);
}

// Funzione utilizzata per determinare se la casella
// in posizione "pos" è una casella bianca, dunque
// utilizzabile nel gioco e vuota.
Damiera.prototype.casellaBianca = function(pos){
	if(this.posizioniPedine[pos]==0) return true;
	return false;
}

// Funzione che disegna una casella/pedina di un determinato
// tipo in una determinata posizione: tip/pos.
Damiera.prototype.disegnaPedina = function(pos,tip){
	var immagine = document.getElementById(pos);
	var source = "";
	if(tip==0){source = "./css/img/casellaGrigia.png";}
	else if(tip==1){source = "./css/img/pedinaRossa.png";}
	else if(tip==2){source = "./css/img/pedinaGrigia.png";}
	else if(tip==3){source = "./css/img/damaRossa.png";}
	else if(tip==4){source = "./css/img/damaGrigia.png";}
		
	immagine.setAttribute("src", source);
}

// Funzione che scorre tutto l'array delle posizioni della
// scacchiera. Chiama la disegnaPedina e aggiorna le immagini
// nella damiera rispettando l'array.
Damiera.prototype.disegnaPedine = function(){
	var j = 0;
	while(j < 64){
		if(this.posizioniPedine[j]==0){this.disegnaPedina(j,0);}
		else if(this.posizioniPedine[j]==1){this.disegnaPedina(j,1);}
		else if(this.posizioniPedine[j]==2){this.disegnaPedina(j,2);}
		else if(this.posizioniPedine[j]==3){this.disegnaPedina(j,3);}
		else if(this.posizioniPedine[j]==4){this.disegnaPedina(j,4);}
		j++;
	}
	return;
}

// Funzione che controlla, nel caso in cui si faccia uno spostamento
// da "da" ad "a" della lunghezza maggiore di una casella, se è presente
// una pedina nella casella di mezzo tra "da" ed "a". Se la pedina esiste
// e può essere mangiata allora viene mangiata e la funzione restituisce true,
// altrimenti la funzione restituisce false.
Damiera.prototype.mangiaPedina = function(da,a){ 
	var da = parseInt(da);
	var a = parseInt(a);
	// Se la pedina sta provando a saltare due caselle:
	if( (a==(da-16)+2||a==(da-16)-2) || (a==(da+16)+2||a==(da+16)-2) ){
		var pedinaDaMangiare = 0;
		var posizioneDaMangiare = 0;
		var coloreMovente = this.posizioniPedine[da];
		var coloreDaMangiare = 0;
		// Calcolo eventuali pedine di mezzo che possono essere mangiate:
		if(a==(da-16)+2){pedinaDaMangiare = this.posizioniPedine[da-7]; posizioneDaMangiare = da-7;} // Se si muove in su a destra.
		else if(a==(da-16)-2){pedinaDaMangiare = this.posizioniPedine[da-9]; posizioneDaMangiare = da-9;} // Se si muove in su a sinistra.
		else if(a==(da+16)+2){pedinaDaMangiare = this.posizioniPedine[da+9]; posizioneDaMangiare = da+9;} // Se si muove in giù a destra.
		else if(a==(da+16)-2){pedinaDaMangiare = this.posizioniPedine[da+7]; posizioneDaMangiare = da+7;} // Se si muove in giù a sinistra.
		coloreDaMangiare = this.posizioniPedine[posizioneDaMangiare];
		if(coloreDaMangiare==0 || coloreDaMangiare==5){return false;}
		if(coloreMovente==3 && (coloreDaMangiare==2 || coloreDaMangiare==4)){this.posizioniPedine[posizioneDaMangiare]=0; return true;}
		if(coloreMovente==4 && (coloreDaMangiare==1 || coloreDaMangiare==3)){this.posizioniPedine[posizioneDaMangiare]=0; return true;}
		if(coloreMovente==1 && coloreDaMangiare==2){this.posizioniPedine[posizioneDaMangiare]=0; return true;}
		if(coloreMovente==2 && coloreDaMangiare==1){this.posizioniPedine[posizioneDaMangiare]=0; return true;}
		return false;
	}
	return false;
}

// Controlla, in base al colore della pedina,
// se la pedina si sta spostando nella direzione giusta.
Damiera.prototype.direzioneGiusta = function(da,a){
	// Se è una dama, va bene sia su che giù:
	if(this.posizioniPedine[da]==3 || this.posizioniPedine[da]==4) return true;
	// Se invece non è una dama, controllo che si muova nella direzione giusta:
	var colore = this.posizioniPedine[da];
	var daRiga = Math.floor(da/8);
	var aRiga = Math.floor(a/8);
	if(colore==1 && daRiga-aRiga<=0){return false;} // Una pedina bianca vuole andare indietro.
	else if(colore==2 && daRiga-aRiga>=0){return false;} // Una pedina nera vuole andare indietro.
	return true;
}

// Funzione che determina se la pedina su "da"
// si sta spostando soltando di una casella
// andando su "a".
Damiera.prototype.siSpostaDiUnaCasella = function(da,a){
	var da = parseInt(da);
	var a = parseInt(a);
	if((a==(da-7)||a==(da-9)) || (a==(da+9)||a==(da+7))) return true;
	return false;
}

// Restituisce true se si può effettuare uno spostamento
// di una pedina dalla posizione "da" alla posizione "a".
Damiera.prototype.spostamentoOk = function(da,a){
	// Controllo che la destinazione sia una casella bianca 
	// e vuota e che si muova effettivamente una pedina.
	if(this.casellaBianca(a) && this.posizioniPedine[da]!=0){
		// Controllo che ci si muova nella direzione giusta per il determinato
		// colore, O che sia una dama, che si muove sia in su che in giù.
		if(this.direzioneGiusta(da,a)){
			// Controllo che ci si muova solo di una casella, 
			// OPPURE, se ci si muove di due, che venga 
			// mangiata una pedina che stava di mezzo.
			if(this.mangiaPedina(da,a) || this.siSpostaDiUnaCasella(da,a)){
				return true;
			}
			else{return false;}
		}
		else{return false;}
	}
	else{return false;}
}

// Se è il caso, promuove una pedina a dama.
// Dopo l'esecuzione necessita chiamare la disegnaPedine.
Damiera.prototype.promuoviPedina = function(pos){
	if((pos>=0&&pos<=7) || (pos>=56&&pos<=63)){ 
		var colorePedina = this.posizioniPedine[pos];
		var coloreBase = -1;
		if(pos>=0&&pos<=7) coloreBase = 2;
		if(pos>=56&&pos<=63) coloreBase = 1;
		if(coloreBase==-1) return false;
		if(colorePedina!=coloreBase){
			if(coloreBase==1) this.posizioniPedine[pos] = 4;
			if(coloreBase==2) this.posizioniPedine[pos] = 3;
			return true;
		}
		return false;
	}
	return false;
}

// Questa funzione, dopo aver effettuato tutti i controlli necessari,
// sposta il contenuto di una casella in un altra casella, e se necessario,
// promuove la pedina a dama. In fine chiama la funzione disegnaPedine per
// aggiornare lo schermo.
Damiera.prototype.spostaPedina = function(da,a){
	if(!this.spostamentoOk(da,a)) return false;
	this.posizioniPedine[a] = this.posizioniPedine[da];
	this.posizioniPedine[da] = 0;
	this.promuoviPedina(a);
	this.disegnaPedine();
	return true;
}

// Funzione di utilità grafica gestita nell'apparato controlli.
Damiera.prototype.selezionaPedina = function(pos){
	if(this.posizioniPedine[pos]==5 || this.posizioniPedine[pos]==0) return false;
	var img = document.getElementById(pos);
	var source="";
	if(this.posizioniPedine[pos]==1){source="./css/img/pedinaRossaSel.png";}
	else if(this.posizioniPedine[pos]==2){source="./css/img/pedinaGrigiaSel.png";}
	else if(this.posizioniPedine[pos]==3){source="./css/img/damaRossaSel.png";}
	else if(this.posizioniPedine[pos]==4){source="./css/img/damaGrigiaSel.png";}
	img.setAttribute("src",source);
	return true;
}

// Funzione di utilità grafica gestita nell'apparato controlli.
Damiera.prototype.deselezionaPedina = function(pos){
	if(this.posizioniPedine[pos]==5 || this.posizioniPedine[pos]==0) return false;
	var img = document.getElementById(pos);
	var source="";
	if(this.posizioniPedine[pos]==1){source="./css/img/pedinaRossa.png";}
	else if(this.posizioniPedine[pos]==2){source="./css/img/pedinaGrigia.png";}
	else if(this.posizioniPedine[pos]==3){source="./css/img/damaRossa.png";}
	else if(this.posizioniPedine[pos]==4){source="./css/img/damaGrigia.png";}
	img.setAttribute("src",source);
	return true;
}

Damiera.prototype.reset = function(){
	this.posizioniPedine = [2,5,2,5,2,5,2,5, 
							5,2,5,2,5,2,5,2,
							2,5,2,5,2,5,2,5,
							5,0,5,0,5,0,5,0,
							0,5,0,5,0,5,0,5,
							5,1,5,1,5,1,5,1,
							1,5,1,5,1,5,1,5,
							5,1,5,1,5,1,5,1];
	this.disegnaPedine();
	return true;
}