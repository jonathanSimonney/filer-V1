<?php
include '../../../include/functionsPhp/requiredFields.php';
include '../../../include/functionsPhp/isNotAlreadyInDb.php';

$errorMessage = "";

requiredField("username");
requiredField("email");
requiredField("password");
requiredField("confirmationOfPassword");
requiredField("indic");

isNotAlreadyInDb($_POST["username"], "username", "users");//BONUS : in the function, add a suggestion of other username
isNotAlreadyInDb($_POST["email"], "email", "users");

$re = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
if (preg_match($re, $_POST["email"]) != 1) {
	$errorMessage .= "Your email adress is invalid.<br>";
}

if ($_POST["password"] != $_POST["confirmationOfPassword"]) {
	$errorMessage .= "You must write the same thing in the fields password and confirmation of password<br>";
}//BONUS : add a security level of password

if (strlen($_POST["password"]) <= 8) {
	$errorMessage .= "your password must do at least 8 characters";
}

if ($errorMessage == "") {
	try{
		$db = new PDO("mysql:host=localhost;dbname=filer","root","password");

		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$request = "INSERT INTO `users` (`id`, `username`, `password`, `email`, `indic`) VALUES (:id, :username, :password, :email, :indic);";//BEWARE! not written in the same order than in db.
		$statement = $db->prepare($request);
		$statement->execute([
			'id' => NULL,
			'username' => $_POST["username"],
			'password' => $_POST["password"],
			'email' => $_POST["email"],
			'indic' => $_POST["indic"]
			]);
	}

	catch(PDOException $e){
		echo $e;
	}

	$db = null;

	mkdir('../../files/'.htmlspecialchars($_POST["username"]));//create folder for user file

	$arrayReturned = [
	"Your inscription is successful! Welcome among us <i>".htmlspecialchars($_POST["username"])."</i>. <br>You'll soon be redirected to home to confirm your inscription by logging in.",
	"formOk" => true
	];
}else{
	$arrayReturned = [
	$errorMessage,
	"formOk" => false
	];
}

echo json_encode($arrayReturned);