<?php
	require_once __DIR__ . "/../config.php";
	require_once DIR_PHP . "dbManager.php";
	
	session_start();
	function setSession($username, $userId){
		$_SESSION['userId'] = $userId;
		$_SESSION['username'] = $username;
		return;
	}

	function isLogged(){		
		if(isset($_SESSION['userId']))
			return true;
		else
			return false;
	}
	
	function setMatch($opponentid, $matchid){
		$_SESSION['opponentId'] = $opponentid;
		$_SESSION['matchId'] = $matchid;
		return;
	}
	
	function matchLogout(){
		global $dbDamaOnline;
		if(!isInMatch()) return false;
		$querytext = "UPDATE Partite SET finito='".$_SESSION['opponentId']."' ".
					 "WHERE id_match='".$_SESSION['matchId']."'";
		$dbDamaOnline->performQuery($testoQuery);
		$dbDamaOnline->closeConnection();
	}
	
	function unsetMatch(){
		unset($_SESSION['opponentId']);
		unset($_SESSION['matchId']);
		return;
	}
	
	function isInMatch(){
		if(isset($_SESSION['matchId']))
			return true;
		else
			return false;
	}
?>