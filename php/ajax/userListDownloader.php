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

	$testoQuery = "SELECT nickname ".
				  "FROM Utenti ".
				  "WHERE ora_online=true";

	$risultato = $dbDamaOnline->performQuery($testoQuery);
	
	$output = "";
	// trasforma in stringa separata da spazi 
	// i valori della colonna specificata di tutte le righe:
	$output = $dbDamaOnline->columnToString($risultato,"nickname"," ");

	echo $output;
	
	$dbDamaOnline->closeConnection();
?>