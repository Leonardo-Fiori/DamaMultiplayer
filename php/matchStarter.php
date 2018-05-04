<?php
	require_once __DIR__ . "/../config.php";
	session_start();
	require_once DIR_PHP . "dbManager.php";
	require_once DIR_PHP . "sessionManager.php";

    if (!isLogged()){
		    header('Location: ../index.php');
		    exit;
    }
	
	$errNoUserFound = "Non ho trovato nessuno ...";
	$errCouldNotStart = "Persona non disponibile!";
	$errSpecifyUser = "Inserisci un nome utente!";
	
	if(isInMatch()){
		global $dbDamaOnline;		

		$testoQuery = "UPDATE Partite ".
					  "SET ultimo_turno='".$_SESSION['opponentId']."', ".
					  "finito='".$_SESSION['opponentId']."' ".
					  "WHERE id_match='".$_SESSION['matchId']."' ";
		$ris = $dbDamaOnline->performQuery($testoQuery);
		$dbDamaOnline->closeConnection();
			
		unsetMatch();
	}
	
	if (isset($_POST['rival_nickname'])){
		$rivale = $_POST['rival_nickname'];
		$makemsg = matchmake($rivale);
		if($makemsg==="NoUserFound"){
			header('location: ../matchMaker.php?error='.$errNoUserFound);
		}
		else{
			// Se hai trovato l'utente disponibile,
			// avvia il match creandolo o entrando.
			$startedmsg = matchstart($makemsg);
			$dbDamaOnline->closeConnection();
			if($startedmsg === "Joined" || $startedmsg === "Created")
				header('location: ../board.php?rival='.$rivale.'&start='.$startedmsg);
			else
				header('location: ../matchMaker.php?error='.$errCouldNotStart);
		}
	}
	else{
		header('location: ../matchMaker.php?error='.$errSpecifyUser);
	}
	
	// FUNZIONI UTILIZZATE
	
	function matchmake($rival){		
		if($rival == "random")
			$testoQuery = "SELECT id_utente FROM Utenti WHERE ora_online=true and id_utente !='".$_SESSION['userId']."'";
		else
			$testoQuery = "SELECT id_utente FROM Utenti WHERE nickname='".$rival."' and ora_online=true and id_utente !='".$_SESSION['userId']."'";
			
		global $dbDamaOnline;
		$risultato = $dbDamaOnline->performQuery($testoQuery);
		$numeroTuple = $dbDamaOnline->countRows($risultato);
		
		if($numeroTuple > 0){
			$riga = $dbDamaOnline->rowToArray($risultato);
			$rivalid = $riga['id_utente'];
			return $rivalid;
		}
		else{
			return "NoUserFound";
		}
	}
	
	function matchstart($opponentid){
		// Controlla che non sia già in un match:
		if(isInMatch()!=false)
			return false;
		
		// Cerca se qualcuno ha già proposto questo match:
		$testoQuery = "SELECT id_match, id_utente1 ".
					  "FROM Partite ".
					  "WHERE id_utente2='".$_SESSION['userId']."' ".
					  "and id_utente1='".$opponentid."' ".
					  "and ultimo_turno='".$_SESSION['userId']."' ".
					  "and finito is null";
					  
		// Connessione dal database:
		global $dbDamaOnline;

		$risultato = $dbDamaOnline->performQuery($testoQuery);
		//$dbDamaOnline->closeConnection();
		$numeroTuple = $dbDamaOnline->countRows($risultato);
		
		if($numeroTuple == 1) {
			// Se qualcuno aveva già proposto la partita, entra.
			
			// Rieseguo la query e ottengo l'id del match.
			$testoQuery = "SELECT id_match, id_utente1 ".
						  "FROM Partite ".
						  "WHERE id_utente2='".$_SESSION['userId']."' ".
						  "and id_utente1='".$opponentid."' ".
						  "and ultimo_turno='".$_SESSION['userId']."' ".
						  "and finito is null";
			$sql = $dbDamaOnline->performQuery($testoQuery);
			$riga = $dbDamaOnline->rowToArray($sql);
			$risultato = $riga['id_match'];
			
			// Salva id match in sessione.
			setMatch($opponentid, $risultato);
			return "Joined";
		}
		else if ($numeroTuple == 0){
			// Se invece il match non era ancora stato proposto:
			$testoQuery = "INSERT INTO Partite(id_utente1, id_utente2, ultimo_turno, finito, muovi_da, muovi_a) " .
						  "VALUES ('".$_SESSION['userId']."','".$opponentid."','".$opponentid."',NULL,0,0)";
			$dbDamaOnline->performQuery($testoQuery);
			
			// Una volta creato, salva l'id del match creato:
			$testoQuery = "SELECT id_match, id_utente2 FROM Partite WHERE id_utente1='".$_SESSION['userId']."' ". 
					      "and id_utente2='".$opponentid."' and finito is null";
			
			$sql = $dbDamaOnline->performQuery($testoQuery);		
			$riga = $dbDamaOnline->rowToArray($sql);
			$risultato = $riga['id_match'];
			
			// Salva id match in sessione.
			setMatch($opponentid, $risultato);
			return "Created";
		}
		else if($numeroTuple > 1){
			// Se c'era più di una proposta del solito 
			// rivale verso l'utente della sessione, è un errore. 
			return false;
		}
		else{
			// Qualcosa è andato storto!
			return false;
		}
		return false;
	}
?>