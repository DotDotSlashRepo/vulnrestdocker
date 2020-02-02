<?php
	
	if (empty($connect)) {
    	require "connect.php";
	}

	$db = "png";

	if (!mysqli_select_db($connect,$db)) {
	
	    echo("creating database 'png'!<br/>");
	    mysqli_query($connect,'CREATE DATABASE '. $db);
	
	} else {
		echo("'png' database already exists!<br/>");
	}

	$selectingDatabase = true;
	mysqli_select_db($connect, "png");
	//$connect->selectDB();

?>