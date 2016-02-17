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
		{
			$postdata = "name=Audiochat&no=".$mob."&msg=You have a new friend request from ".$_SESSION['name'];
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL,'http://faltusms.tk/sendSms.php');  
			curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 			
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
			curl_setopt($ch, CURLOPT_VERBOSE, 1); 
			curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
			curl_setopt ($ch, CURLOPT_POST, 1); 
			$result = curl_exec($ch);
			die("");
		}
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
