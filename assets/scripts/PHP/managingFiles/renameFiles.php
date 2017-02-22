<?php
include "../../../../include/functionsPhp/toCheckIfRightUser.php";

if ($canBeThere) {
	include "../../../../include/functionsPhp/requiredFields.php";

	$errorMessage = "";

	requiredField("name");

	$_SESSION["errorMessage"] = $errorMessage;
	$name = $_POST["name"];

	$type = $informationsFile["fileType"];

	$name = preg_replace('/\.'.$type.'(?!=.)/', '', $name);

	$oldFileNameWithType = $informationsFile["nameFile"].".".$informationsFile["fileType"];
	$newFileNameWithType = $name.".".$informationsFile["fileType"];

	$newPathFile = preg_replace('/'.$oldFileNameWithType.'(?!=.)/', $newFileNameWithType, $informationsFile["pathFile"]);


	if ($_SESSION["errorMessage"] == "") {

		rename($informationsFile["pathFile"], $newPathFile);


		try{
			$db = new PDO("mysql:host=localhost;dbname=filer","root","password");

			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$request = "UPDATE `files` SET `nameFile` = :name, `pathFile` = :pathFile WHERE `files`.`id` = ".$informationsFile["id"].";";
			$statement = $db->prepare($request);
			$statement->execute([
				'name' => $name,
				'pathFile' => $newPathFile
			]);	
		}

		catch(PDOException $e){
			echo $e;
		}
	}

	header("Location: ../../../../pages/connected/listFiles.php");
	exit();
}