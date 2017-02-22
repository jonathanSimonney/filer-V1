<?php
include "../../../../include/functionsPhp/toCheckIfRightUser.php";

if ($canBeThere) {
	

	unlink($informationsFile["pathFile"]);


	try{
		$db = new PDO("mysql:host=localhost;dbname=filer","root","password");

		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$request = "DELETE FROM `files` WHERE `files`.`id` = ".$informationsFile["id"].";";
		$statement = $db->prepare($request);
		$statement->execute();	
	}

	catch(PDOException $e){
		echo $e;
	}






	header("Location: ../../../../pages/connected/listFiles.php");
	exit();
}