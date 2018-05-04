<?php
	require_once __DIR__ . "/../config.php";

	class DamaOnlineDbManager{
		private $host = "127.0.0.1";
		private $user = "root";
		private $password = "";
		private $database = "dama_online";
		private $connection = null;
				
		/* FUNZIONI BASE */

		function DamaOnlineDbManager(){
			$this->openConnection();
		}
		
		function isOpened(){
			return ($this->connection != NULL);
		}
		
		function openConnection(){
			if(!$this->isOpened()){
				$this->connection = mysqli_connect($this->host, $this->user, $this->password)
				or die("Connessione non riuscita ".mysqli_error($this->connection));
				
				mysqli_select_db($this->connection, $this->database)
				or die("Selezione database non riuscita ".mysqli_error($this->connection));
			}
		}
		
		function closeConnection(){
			if($this->isOpened()){
				mysqli_close($this->connection);
				$this->connection = null;
			}
		}
		
		function performQuery($text){
			if(!$this->isOpened()) 
				$this->openConnection();
			
			$res = mysqli_query($this->connection,$text)
			or die("Query fallita ".mysqli_error($this->connection));
			
			return $res;
		}
		
		function sqlInjectionFilter($parameter){
			if(!$this->isOpened()) 
				$this->openConnection();
				
			return mysqli_real_escape_string($this->connection,$parameter);
		}
		
		/* UTILITA' */
		
		function countRows($result){
			if(!$this->isOpened()) 
				$this->openConnection();
			
			return mysqli_num_rows($result); 
		}
		
		function rowToArray($result){
			if(!$this->isOpened())
				$this->openConnection();
		
			$arr = mysqli_fetch_assoc($result);
			return $arr;
		}
		
		function rowsToMatrix($result){
			if(!$this->isOpened())
				$this->openConnection();
			
			$numRows = mysqli_num_rows($result);
			$cont = 0;
			
			while($cont<$numRows){
				$arr[$cont] = mysqli_fetch_assoc($result);
				$cont+=1;
			}
			return $arr;
		}
	
		function columnToString($result,$fieldname,$separator){
			if(!$this->isOpened()) 
				$this->openConnection();
			
			$riga = "";
			$output = "";
			while($riga = mysqli_fetch_assoc($result)){
				$output .= $riga[$fieldname].$separator;
			}
			return $output;
		}
	}
	
	$dbDamaOnline = new DamaOnlineDbManager();
?>