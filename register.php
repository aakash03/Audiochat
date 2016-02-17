<?php
 include("php/db.php");
 
 echo "Registered successfully";
 $FName = $_POST['First-Name'];
 $LName = $_POST['Last-Name'];
 $mobile = $_POST['Mobile-Number'];
 $pwd = $_POST['Password'];
 
 $name = $FName . " " . $LName;
 
 $result = mysqli_query($conn,"INSERT INTO user (name,mobile,password) VALUES ('$name','$mobile','$pwd')");
 $postdata = "name=Audiochat&no=".$mobile."&msg=Thank you for registering on audiochat. Call 04433012998 to start audiochatting.";
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
 header("Location: index.php");
?>
