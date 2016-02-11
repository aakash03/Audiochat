<?php
	include("php/db.php");
	
	$mobile = $_POST['Mobile-Number'];
	$pwd = $_POST['Password'];
	
	$res = mysqli_query($conn, "SELECT * FROM user WHERE mobile = '$mobile' AND password = '$pwd'");

	if( mysqli_num_rows($res) > 0 ) {
		session_start();
		
		$row = mysqli_fetch_assoc($res);
		
		$_SESSION['id'] = $row['id'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['loggedin'] = 1;
		$_SESSION['mobile'] = $row['mobile'];
		
		header("Location: home.php");
	}
	else
		die("Incorrect Username or Password!");
?>
