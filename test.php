<?php
	require_once __DIR__ . "/config.php";
	session_start();
    require_once DIR_PHP . "sessionManager.php";

	echo "Your user id: ".$_SESSION['userId']." <br>";
	echo "Your nickname: ".$_SESSION['userId']." <br>";
	echo "Are you in a match? ".isInMatch()." <br>";
	echo "Your match id: ".$_SESSION['matchId']." <br>";
	echo "Your opponent id: ".$_SESSION['opponentId']." <br>";
?>