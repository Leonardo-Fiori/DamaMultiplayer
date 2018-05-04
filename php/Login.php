<?php
	require_once __DIR__ . "/../config.php";
	session_start();
	require_once DIR_PHP . "dbManager.php";
	require_once DIR_PHP . "sessionManager.php";

	$username = $_POST['username'];
	$password = $_POST['password'];

	function login($username, $password){
		if ($username != null && $password != null){
			$userId = authenticate($username, $password);
			if ($userId != -1){
				session_start();
				setSession($username, $userId);
				return null;
			}
		}
		else{
			return 'Inserisci username e password!';
		}
			
		return 'Username o password errati!';
	}
		
	function authenticate ($username, $password){
		global $dbDamaOnline;
		$username = $dbDamaOnline->sqlInjectionFilter($username);
		$password = $dbDamaOnline->sqlInjectionFilter($password);

		$queryText = "SELECT * FROM Utenti WHERE nickname='".$username."' AND pass='".$password ."'";

		$result = $dbDamaOnline->performQuery($queryText);
		$numRow = $dbDamaOnline->countRows($result);
		if ($numRow != 1)
			return -1;
		
		$userRow = $dbDamaOnline->rowToArray($result);
		
		$queryText = "UPDATE Utenti SET ora_online = 1 WHERE id_utente = '".$userRow['id_utente']."'";
		$dbDamaOnline->performQuery($queryText);
		$dbDamaOnline->closeConnection();

		return $userRow['id_utente'];
	}
	
	$errorMessage = login($username, $password);
	if($errorMessage === null)
		header('location: ../matchMaker.php');
	else
		header('location: ../index.php?signIn=Login&errorMessage=' . $errorMessage );	
?>