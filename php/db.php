<?php

	$servername = "br-cdbr-azure-south-a.cloudapp.net:3306";
	$username = "b362327b01741d";
	$password = "545960e6";
	
	$conn = mysqli_connect($servername, $username, $password,'audiochat');
	
	if( !$conn ) {
		die("Unable to connect to db.");
	}
?>
