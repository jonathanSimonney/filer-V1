<?php
include "../../../../include/functionsPhp/toCheckIfRightUser.php";

if ($canBeThere) {
	$_SESSION["errorMessage"] = "";
	$file = $_FILES["file"];


	$oldPathFile = $informationsFile["pathFile"];

	preg_match('/\.[0-9a-z]+$/', $file["name"], $cor);

	$type = $cor[0];

	$nameFile = $informationsFile["nameFile"];

	$pathFile = "../../../files/".$_SESSION["username"]."/".$nameFile.$type;


	if ($oldPathFile != $pathFile) {
		$_SESSION["errorMessage"] = "The file you try to replace does not exist in database. (Check wether the type of the file you wish to replace is the same as the one you wish to upload instead)";
	}elseif(empty($_FILES['file']['name'])){
		$_SESSION["errorMessage"] = "You must choose a file to upload.";
	}





	if ($_SESSION["errorMessage"] == "") {
		$pathFile = "../../../files/".$_SESSION["username"]."/".$nameFile;


		if (!move_uploaded_file($file["tmp_name"], $pathFile)){
			$_SESSION["errorMessage"] = "your file wasn't uploaded. Please try seeing if your username is a valid one.";
		}
	}



	header("Location: ../../../../pages/connected/listFiles.php");
	exit();
}