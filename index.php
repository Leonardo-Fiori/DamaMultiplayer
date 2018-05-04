<?php
	require_once __DIR__ . "/config.php";
	session_start();
    require_once DIR_PHP . "sessionManager.php";

    if (isLogged()){
	    header('Location: ./matchMaker.php');
	    exit;
    }
	
	if(isset($_GET['signIn'])){
		if($_GET['signIn'] == "Login") $action = "Login";
		else if($_GET['signIn'] == "Register") $action = "Register";
		else $action = "Register";
	}
	else $action = "Register";
	
	if($action == "Register")
		$contrary = "Login";
	else
		$contrary = "Register";
?>

<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"> 
    	<meta name = "author" content = "Leonardo Fiori">
   	 	<link rel="shortcut icon" type="image/x-icon" href="./css/img/favicon.ico" />
		<link rel="stylesheet" href="./css/style.css" type="text/css">
		<title>Dama Multiplayer</title>
		<script type="text/javascript" src="./js/effetti/resizer.js"></script>
	</head>
	
	<body onLoad="centerPageDiv('page',-20)" onresize="centerPageDiv('page',-20)">	
		<div class="page" id="page">

		<h1 id="title"> Dama </h1> <h1 id="subtitle"> Multiplayer </h1>
		
		<div id="signin">
			<form name="signinform" action="./php/<?php echo $action ?>.php" method="post">
				<div>
					<label>Username:</label> <br>
					<input type="text" class="textinput" placeholder="USER" name="username" autocomplete="off" required autofocus>
				</div>
				<br>
				<div>
					<label>Password:</label> <br>
					<input type="password" class="textinput" placeholder="*****" name="password" autocomplete="off" required>
				</div> 
				
				<br>
				
				<div id="submit">
				<input type="submit" value="<?php echo $action ?>"> 
				<a href="./index.php?signIn=<?php echo $contrary ?>"> <?php echo $contrary ?> </a>
				</div>
			</form>
		</div>
		
		<?php
			if(isset($_GET['errorMessage'])){
				echo '<br>';
				echo '<p id="error">' . $_GET['errorMessage'] . '</p>';
				echo '<script type="text/javascript">document.getElementById("page").style.opacity="1";</script>';
			}
		?>
		</div>
	</body>
	
</html>
