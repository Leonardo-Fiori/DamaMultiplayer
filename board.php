<?php
	require_once __DIR__ . "/config.php";
	session_start();
    require_once DIR_PHP . "sessionManager.php";

    if (!isLogged()){
		    header('Location: ./index.php');
		    exit;
    }
	
	if(!isset($_GET['rival']) || !isset($_GET['start'])){
		header('Location: ./matchMaker.php');
		exit;
	}
	
	if($_GET['start'] == "Joined")
		$mioturno = 1;
	else
		$mioturno = 0;
	
	$colore = "NERO";
	if($mioturno==1) $colore = "ROSSO"; 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title> Sfida </title>
    	<meta name = "author" content = "Leonardo Fiori">
   	 	<link rel="shortcut icon" type="image/x-icon" href="./css/img/favicon.ico" />
		<link rel="stylesheet" href="./css/style.css" type="text/css">
			
		<script type="text/javascript" src="./js/effetti/resizer.js"></script>
		<script type="text/javascript" src="./js/effetti/alpha_damiera.js"></script>
	</head>
	
	<body onLoad="centerPageDiv('boardpage',-790)" onresize="centerPageDiv('boardpage',-790)">
		<div id="boardpage" class="boardpage">
		
			<h1 id="title"> Dama </h1> <h1 id="subtitle"> Multiplayer </h1>
		
			<div id="playfield" style="opacity: 0"> </div>
			<script type="text/javascript" src="./js/ajaxmanager_obj.js"></script>
			<script type="text/javascript" src="./js/damiera/damiera_obj.js"></script>
			<script type="text/javascript" src="./js/damiera/damiera_controls.js"></script>
			<script type="text/javascript" src="./js/damiera/damiera_network.js"></script>	
			<script type="text/javascript" src="./js/chat/open_chat_popup.js"></script>
			<script type="text/javascript" src="./js/damiera/damiera_closeevent.js"></script>

			<script type="text/javascript">
				// Prima di tutto controlla se la pagina è stata ricaricata
				
				// Se è stato rilevato un refresh, termina immediatamente:
				if(sessionStorage.getItem('refreshed') == "true"){
					surrender();
					stop();
				}
				else{
				// Altrimenti inizializza la partita
				dama = new Damiera();
				dama.disegnaCaselle();
				dama.disegnaPedine();

				mioTurno = <?php echo $mioturno; ?>;
				opponentId = "<?php echo $_GET['rival'] ?>";
				
				var alertText = "Stai sfidando "+opponentId+".";
				if(mioTurno) alertText+="\nSei entrato in un match!";
				else alertText+="\nHai creato un match";
				
				alert(alertText);
				
				if(mioTurno){
					alert("E' il tuo turno! \nMuovi il colore Rosso.");
					checkNewDataInterval(false);
					mioColore = 1;
				}
				else{
					alert("In attesa dell'avversario... \nAl tuo turno muovi il colore Nero.");
					checkNewDataInterval(true);
					mioColore = 2;
				}
				document.getElementById("boardpage").style.opacity="1";
				}
			</script>
			
			<?php
				echo "<br>";
				echo '<div id="matchinfo">';
				echo "<p> ID RIVALE: ".$_SESSION['opponentId']."</p>";
				echo "<p> MUOVI IL: ".$colore." </p>";
				echo 'Apri la <a href="javascript:openChat()">Chat</a> o <a href="javascript:surrender()">Arrenditi</a>';
				echo "</div>";
			?>
		</div>
		
	</body>

</html>