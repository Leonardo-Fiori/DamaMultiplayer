<?php
	require_once __DIR__ . "/config.php";
	session_start();
    require_once DIR_PHP . "sessionManager.php";

    if (!isLogged()){
		    header('Location: ./index.php');
		    exit;
    }
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title> Matchmaker </title>
    	<meta name = "author" content = "Leonardo Fiori">
   	 	<link rel="shortcut icon" type="image/x-icon" href="./css/img/favicon.ico" />
		<link rel="stylesheet" href="./css/style.css" type="text/css">
		<script type="text/javascript" src="./js/effetti/resizer.js"></script>
	</head>
	
	<body onLoad="centerPageDiv('page',-20);" onresize="centerPageDiv('page',-20)">
		<script type="text/javascript" src="./js/ajaxmanager_obj.js"></script>
		
		<div class="chatpage">
			<h1 id="title"> Chat </h1>
			
			<input type="text" maxlength="60" id="textbox">
			<input type="button" value="Invia" onclick="sendPost()">
			
			<br>
			
			<div id ="chatbox">
			</div>
		</div>
		
		<script type="text/javascript" src="./js/chat/chatbox.js"></script>
		
		<script type="text/javascript">
			checkNewPostsInterval(true);
		</script>
	</body>
	
</html>