<?php 
	$server = "imc.kean.edu";
	$login = "nuneelvi";
	$password = "1025095";
	$dbname = "CPS3740";

	$link =  mysqli_connect($server, $login, $password, $dbname);
	if (!$link) {
	    die('Cannot connect to the database' . mysqli_error());
	}
?>