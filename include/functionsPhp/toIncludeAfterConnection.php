<?php
session_start();
$redirectToIndex = true;
if (array_key_exists("isLoggedIn", $_SESSION)) {
	if ($_SESSION["isLoggedIn"]) {
		$redirectToIndex = false;
	}
}

if ($redirectToIndex) {
	$_SESSION["errorMessage"] = "Please connect yourself, for you were not authorized to be on the last page you visited.";
	header('Location: ../../index.php');
	exit();
}else{
	include '../../include/elementsHtml/doctype.html';
}

?>