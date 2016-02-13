<?php
	include("php/db.php");
	include("php/logged.php");
	
	$userid = $_SESSION['id'];
	$audioid = $_POST['id'];
	$res = mysqli_query($conn,"DELETE from audio WHERE id = $audioid");
?>
