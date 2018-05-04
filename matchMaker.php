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
		<script type="text/javascript" src="./js/ajaxmanager_obj.js"></script>
		<script type="text/javascript" src="./js/chat/open_chat_popup.js"></script>
		
		<script type="text/javascript">
			if(sessionStorage.getItem('refreshed'))
				sessionStorage.setItem('refreshed','false');
		</script>
	</head>
	
	<body onLoad="centerPageDiv('page',-20)" onresize="centerPageDiv('page',-20)">
		<div class="page" id="page">
		
			<h1 id="title"> Dama </h1> <h1 id="subtitle"> Multiplayer </h1>
			
			<div id="matchmaker">
			<form name="rival" action="./php/matchStarter.php" method="post">
				<div>
					<label>Scegli il tuo rivale:</label> <br>
					<input type="text" class="textbuttonaside" placeholder="Username" name="rival_nickname" required autofocus>
					<input type="submit" value="Sfida!">
				</div>
				Apri la <a href="javascript:openChat()">Chat</a> o <a href="./php/logout.php">Esci</a>
			</form>
			</div>
			
			<div id="userlist">
				<script type="text/javascript">
					function printList(data){
						document.getElementById("userlist").childNodes[0].nodeValue = data;
					}
					AJAX.performAjaxRequest("POST","./php/ajax/userListDownloader.php",true,null,printList);
				</script>
			</div>
			
			<?php
				if (isset($_GET['error'])){
				echo '<br>';
				echo '<p id="error">' . $_GET['error'] . '</p>';
				}
			?>
			
		</div>
	</body>
	
</html>