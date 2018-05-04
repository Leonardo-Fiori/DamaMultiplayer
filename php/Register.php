<?php
	require_once __DIR__ . "/../config.php";
	session_start();
	require_once DIR_PHP . "dbManager.php";
	require_once DIR_PHP . "sessionManager.php";

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	function checkUsed($username){
		global $dbDamaOnline;
		$username = $dbDamaOnline->sqlInjectionFilter($username);
		$queryText = "SELECT * FROM Utenti WHERE nickname='".$username."'";
		$result = $dbDamaOnline->performQuery($queryText);
		$numRow = $dbDamaOnline->countRows($result);
		if ($numRow != 0)
			return true;
		return false;
	}

	function register($username, $password){
		if($username != null && $password != null){
			$used = checkUsed($username);
			if(!$used){ // se non è stato già usato il nickname...
				global $dbDamaOnline;
				$username = $dbDamaOnline->sqlInjectionFilter($username);
				$password = $dbDamaOnline->sqlInjectionFilter($password);
				
				$queryText = "INSERT INTO Utenti(nickname, pass) ".
							 "VALUES ('".$username."','".$password."')";

				$result = $dbDamaOnline->performQuery($queryText);
				$dbDamaOnline->closeConnection();
				return null;
			}
			else return 'Username non disponibile!';
		}
		else return 'Inserisci username e password!';
		$dbDamaOnline->closeConnection();
	}
	
	$errorMessage = register($username, $password);
	if($errorMessage === null)
		header('location: ../index.php?signIn=Login&errorMessage=Registrato con successo!');
	else
		header('location: ../index.php?signIn=Register&errorMessage=' . $errorMessage );
?>