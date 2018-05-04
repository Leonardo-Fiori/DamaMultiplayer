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
			echo "YouWon";
			unsetMatch();
			exit();
		}
		
		if($turno == $_SESSION['userId']){
			$out[0] = "Move";
			$out[1] = $riga['muovi_da'];
			$out[2] = $riga['muovi_a'];
			echo json_encode($out);
		}
		else if($turno == $_SESSION['opponentId']){ 	
			echo "NoNewData";
		}
		else{
			$errorcode[0] = "Error";
			$errorcode[1] = $turno;
			echo json_encode($errorcode);
		}
		
	}
	else{
		header('Location: ../../index.php');
		exit;
	}
	
	$dbDamaOnline->closeConnection();
?>