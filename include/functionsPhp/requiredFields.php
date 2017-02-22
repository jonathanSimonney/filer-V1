<?php
function requiredField($name){
	global $errorMessage;
	
	$noError = false;

	if (array_key_exists($name, $_POST)) {
		if (strlen($_POST[$name]) != 0) {
			$noError = true;
		}
	}

	if (!$noError) {
		if (preg_match("/[A-Z]{1}/", $name)===1) {
			$name = preg_replace("/([A-Z])/", " $1", $name);
			$name = strtolower($name);
		}
		$errorMessage .= "The field ".$name." is required and you didn't fill it.<br>";
	}
}