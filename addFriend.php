<?php
	include("php/db.php");
	include("php/logged.php");
	
	$userid = $_SESSION['id'];
	
	if( isset( $_POST['mobile'] ) ) {
		$mob = $_POST['mobile'];
		$res = mysqli_query($conn,"SELECT * FROM user WHERE mobile = '$mob'");
		
		if( mysqli_num_rows($res) == 0 ) {
			die("Sorry! The provided mobile number has not yet registered :(");
		}
		
		$row = mysqli_fetch_assoc($res);
		$broid = $row['id'];
		
		$res = mysqli_query($conn,"SELECT * FROM friends WHERE bro_id = $userid AND user_id = $broid");
		if( mysqli_num_rows($res) > 0 )
		  die("Haha :) You already have a friend request from that user!");	
		$res = mysqli_query($conn,"SELECT * FROM friends WHERE user_id = $userid AND bro_id = $broid");
		if( mysqli_num_rows($res) > 0 )
		  die("Whoops! You already have sent a request to that user!");
		
		$res = mysqli_query($conn,"INSERT INTO friends(user_id,bro_id) VALUES( $userid, $broid )"); 
		if( $res ) 
		  die("");
		else
		  die("Some error occured! :(");
		  
	}

	if( isset( $_POST['accept'] ) ) {
		$broid = $_POST['id'];
		
		if( $_POST['accept'] == 1 ) {
			$res = mysqli_query($conn,"UPDATE friends SET status = 1 WHERE user_id = $broid AND bro_id = $userid");
			die("OK");
		}
		else {
			$res = mysqli_query($conn,"DELETE from friends WHERE user_id = $broid AND bro_id = $userid");
			die("OK");
		}
		
		die("Error occured!");
	}

?>
