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
	

	if(isInMatch()){
		$testoQuery = "SELECT nickname, messaggio ".
					  "FROM Chat_Locale ".
					  "WHERE timestampdiff(MINUTE,timestmp,current_timestamp) <= 1 ".
					  "and match_id = ".$_SESSION['matchId']." ".
					  "ORDER BY timestmp DESC";
	}
	else{
		$testoQuery = "SELECT nickname, messaggio ".
					  "FROM Chat ".
					  "WHERE timestampdiff(MINUTE,timestmp,current_timestamp) <= 1 ".
					  "ORDER BY timestmp DESC";
	}
	  
	$ris = $dbDamaOnline->performQuery($testoQuery);
	$mat = $dbDamaOnline->rowsToMatrix($ris);
	$numrows = $dbDamaOnline->countRows($ris);
	
	if($numrows == 0){
		echo "ChatEmpty";
		exit;
	}
	
	$dbDamaOnline->closeConnection();
	echo json_encode($mat);
?>