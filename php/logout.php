<?php
	require_once __DIR__ . "/../config.php";
    session_start();
	require_once DIR_PHP . "dbManager.php";
	require_once DIR_PHP . "sessionManager.php";
    
	matchLogout();
	global $dbDamaOnline;
	$goOff = "UPDATE Utenti SET ora_online = 0 WHERE id_utente='".$_SESSION['userId']."'";
	$dbDamaOnline->performQuery($goOff);
	$dbDamaOnline->closeConnection();
    session_destroy();
	header("Location: ../index.php");
    exit;
?>
