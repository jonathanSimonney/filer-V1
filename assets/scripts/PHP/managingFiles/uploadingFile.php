<?php
include '../../../../include/functionsPhp/isNotAlreadyInDb.php';

session_start();
$_SESSION["errorMessage"] = "";
$file = $_FILES["file"];
$nameFile = $_POST["name"];

preg_match('/\.[0-9a-z]+$/', $file["name"], $cor);

$type = $cor[0];


$nameFile = preg_replace('/'.$type.'(?!=.)/', '', $nameFile);


$pathFile = "../../../files/".htmlspecialchars($_SESSION["username"])."/".$nameFile.$type;


if (strlen($nameFile) == 0) {
	$_SESSION["errorMessage"] = "You must put a name on your file.";
}elseif(!isNotAlreadyInDb($pathFile,"pathFile","files")){
	$_SESSION["errorMessage"] = "The name ".$nameFile." is already used for one of your files. Please type another name or use the replace button.";
}elseif(empty($_FILES['file']['name'])){
	$_SESSION["errorMessage"] = "you must choose a file to upload.";
}





if ($_SESSION["errorMessage"] == "") {

	$type = str_replace(".", "", $type);


	if (!move_uploaded_file($file["tmp_name"], $pathFile)){
		$_SESSION["errorMessage"] = "your file wasn't uploaded. Please try seeing if your username is a valid one.";
	}else{
		try{
			$db = new PDO("mysql:host=localhost;dbname=filer","root","password");

			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$request = "INSERT INTO `files` (`id`, `nameFile`, `pathFile`, `fileType`, `user_id`) VALUES (NULL, :nameFile, :pathFile, :fileType, ".$_SESSION["idUser"].");";

			$statement = $db->prepare($request);

			

			$statement->execute([
				'nameFile' => $nameFile,
				'pathFile' => $pathFile,
				'fileType' => $type
			]);

			$db = null;
		}

		catch(PDOException $e){
			echo $e;
		}
	}	
}




header("Location: ../../../../pages/connected/listFiles.php");
exit();