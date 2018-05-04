<?php
	require_once __DIR__ . "/../../config.php";
	session_start();
	require_once DIR_PHP . "dbManager.php";
	require_once DIR_PHP . "sessionManager.php";
	
    if (!isLogged()){
		header('Location: ./index.php');
		exit;
    }
	
	if(isInMatch()){
		global $dbDamaOnline;
		// Seleziona muovida e muovia dalla tabella match,
		// dove l'id del match corrisponde al mio id match.
		$testoQuery = "SELECT ultimo_turno, muovi_da, muovi_a, finito ".
					  "FROM Partite ".
					  "WHERE id_match=".$_SESSION['matchId'];
					  //"and ultimo_turno='".$_SESSION['userId']."'";
		$risultato = $dbDamaOnline->performQuery($testoQuery);
		
		//$numeroTuple = mysql_num_rows($risultato);
		$riga = $dbDamaOnline->rowToArray($risultato);
		$finito = $riga['finito'];
		$turno = $riga['ultimo_turno'];
		
		if($finito == $_SESSION['userId']){
			echo json_encode("YouWon");
			unsetMatch();
			exit();
		}
		
		if($turno == $_SESSION['userId']){
			$da_a = $riga['muovi_da']." ".$riga['muovi_a'];
			echo 'Move '.$da_a;
		}
		else if($turno == $_SESSION['opponentId']){ 	
			echo "NoNewData";
		}
		else{
			echo "Error ".$turno;
		}
		
	}
	else{
		header('Location: ./index.php');
		exit;
	}
	
	$dbDamaOnline->closeConnection();
?>