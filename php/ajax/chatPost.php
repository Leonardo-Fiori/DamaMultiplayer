<?php
	require_once __DIR__ . "/../../config.php";
	session_start();
	require_once DIR_PHP . "dbManager.php";
	require_once DIR_PHP . "sessionManager.php";
	
    if (!isLogged()){
		header('Location: ./index.php');
		exit;
    }
	
	global $dbDamaOnline;
	$testoQuery = "";
	
	if(isset($_POST['message'])){
		$msg = $dbDamaOnline->sqlInjectionFilter($_POST['message']);
	}
	else{
		echo "Error";
		exit;
	}
	

	if(isInMatch()){
		$testoQuery = "INSERT INTO Chat_Locale(nickname,timestmp,messaggio,match_id) ".
					  "VALUES ('".$_SESSION['username']."',current_timestamp,'".$msg."',".$_SESSION['matchId'].")";
	}
	else{
		$testoQuery = "INSERT INTO Chat(nickname,timestmp,messaggio) ".
					  "VALUES ('".$_SESSION['username']."',current_timestamp,'".$msg."')";
	}

	$dbDamaOnline->performQuery($testoQuery);
	$dbDamaOnline->closeConnection();
	echo "Ok";

?>