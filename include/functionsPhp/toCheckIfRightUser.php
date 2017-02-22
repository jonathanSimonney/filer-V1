<?php
session_start();
$canBeThere = true;

try{
		$db = new PDO("mysql:host=localhost;dbname=filer","root","password");

		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$request = "SELECT * FROM `files` WHERE `files`.`id` = ".$_POST["notForUser"].";";
		$statement = $db->prepare($request);
		$statement->execute();

		$arrayInformationsFile = $statement->fetchAll(PDO::FETCH_ASSOC);	
	}

	catch(PDOException $e){
		echo $e;
	}

$informationsFile = $arrayInformationsFile[0];


if ($_SESSION['idUser'] != $informationsFile["user_id"]) {
	$canBeThere = false;
	header('Location: ../logOut.php');
	exit();
}
