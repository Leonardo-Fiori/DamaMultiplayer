var mioTurno = true;
var mioColore = 1;
var primoClick = false;
var coloreSelezionato = -1;
var muoviDa = -1;
var muoviA = -1;
var numero = 0;
var matchId = null;
var opponentId = null;

function controlPawn(casella){
	if(!mioTurno) return false;
	if(!primoClick){		
		numero = parseInt(casella.getAttribute('id'));
		
		// creare funzione per accedere al colore?
		if(dama.posizioniPedine[numero]==4 || dama.posizioniPedine[numero]==2)
			coloreSelezionato = 2;
		
		if(dama.posizioniPedine[numero]==3 || dama.posizioniPedine[numero]==1)
			coloreSelezionato = 1;
	
		if(coloreSelezionato!=mioColore || dama.posizioniPedine[numero]==5)
			return false;
		
		primoClick = !primoClick;
		muoviDa = numero;
		dama.selezionaPedina(numero);
		return true;
	}
	else{
		numero = parseInt(casella.getAttribute('id'));
		
		if(muoviDa == numero){
			primoClick = !primoClick;
			dama.deselezionaPedina(muoviDa);
			return false;
		}
		
		if(dama.posizioniPedine[numero]==4 || dama.posizioniPedine[numero]==2)
			coloreSelezionato = 2;
		
		if(dama.posizioniPedine[numero]==3 || dama.posizioniPedine[numero]==1)
			coloreSelezionato = 1;
		
		if(coloreSelezionato!=mioColore || dama.posizioniPedine[numero]==5){
			dama.deselezionaPedina(muoviDa);
			primoClick = !primoClick;
			return false;
		}
		
		primoClick = !primoClick;
		muoviA = numero;

		if(dama.spostaPedina(muoviDa, muoviA)){
			dama.spostaPedina(muoviDa, muoviA);
			sendNewMatchData(muoviDa, muoviA);
			mioTurno=false;
			checkNewDataInterval(true);
			return true;		
		}
		else{
			dama.deselezionaPedina(muoviDa);
			primoClick = !primoClick;
			return false;
		}
	}
}

/* Serve per uscire dalla pagina in una situazione
generica. Dopo aver perso o ricaricato la pagina, o anche
dopo aver vinto la partita. La funzione non fa perdere il match,
semplicemente esce dalla pagina. */
function stop(){
	checkNewDataInterval(false);
	mioTurno=false;
	window.location.href = "./matchMaker.php";
}

/* Da usare quando: l'utente ricarica o esce volontariamente
dalla pagina o quando clicca "Arrenditi". Prima viene terminato
il match lato server via ajax, poi l'utente viene avvisato e in fine
viene chiamata la stop() */
function surrender(){
	sendStopMatch();
	stop();
}