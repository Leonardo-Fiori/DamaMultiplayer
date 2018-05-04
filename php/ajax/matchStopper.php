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

		$testoQuery = "UPDATE Partite ".
					  "SET ultimo_turno='".$_SESSION['opponentId']."', ".
					  "finito='".$_SESSION['opponentId']."' ".
					  "WHERE id_match='".$_SESSION['matchId']."' ";
		$ris = $dbDamaOnline->performQuery($testoQuery);
		$dbDamaOnline->closeConnection();
			
		unsetMatch();
		echo "YouLose ".$ris;
	}
	else{
		header('Location: ./index.php');
		exit;
	}
?>