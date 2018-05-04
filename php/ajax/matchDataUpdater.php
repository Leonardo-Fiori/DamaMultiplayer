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
		if(!isset($_POST['movefrom']) || !isset($_POST['moveto'])){
			echo "Error ".$_POST['movefrom']." ".$_POST['moveto'];
			exit();
		}
		
		global $dbDamaOnline;		

		$testoQuery = "UPDATE Partite ".
					  "SET ultimo_turno='".$_SESSION['opponentId']."', ".
					  "muovi_da='".$_POST['movefrom']."', muovi_a='".$_POST['moveto']."' ".
					  "WHERE id_match='".$_SESSION['matchId']."'";
		$dbDamaOnline->performQuery($testoQuery);
		$dbDamaOnline->closeConnection();
		echo "Sent";
	}
	else{
		header('Location: ./index.php');
		exit;
	}
?>