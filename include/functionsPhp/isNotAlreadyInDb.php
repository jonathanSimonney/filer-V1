<?php
function isNotAlreadyInDb($needle, $column, $table){
	global $errorMessage;
	try{
		$db = new PDO("mysql:host=localhost;dbname=filer","root","password");

		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$request = "SELECT ".$column." FROM ".$table." ;";
		$statement = $db->prepare($request);
		$statement->execute();

		$arrayColumn = $statement->fetchAll(PDO::FETCH_ASSOC);	
	}

	catch(PDOException $e){
		echo $e;
	}

	foreach ($arrayColumn as $key => $value) {
		if ($value[$column] == $needle) {
			$errorMessage .= "Sorry, but the ".$column." <i>".htmlspecialchars($needle)."</i> is already taken, please choose another one.<br>";
			$db = null;
			return false;
		}
	}

	$db = null;
	return true;
}