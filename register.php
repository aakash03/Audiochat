<?php
 include("php/db.php");
 
 echo "Registered successfully";
 $FName = $_POST['First-Name'];
 $LName = $_POST['Last-Name'];
 $mobile = $_POST['Mobile-Number'];
 $pwd = $_POST['Password'];
 
 $name = $FName . " " . $LName;
 
 $result = mysqli_query($conn,"INSERT INTO user (name,mobile,password) VALUES ('$name','$mobile','$pwd')");
 header("Location: index.php");
?>
