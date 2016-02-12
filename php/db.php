<?php

	$servername = "localhost";
	$username = "root";
	$password = "password";
	
	$conn = mysqli_connect($servername, $username, $password,'audiochat');
	
	if( !$conn ) {
		die("Unable to connect to db.");
	}
?>
