<?php
include("php/db.php");
session_start();
require_once("response.php");//include KooKoo library
$r=new Response(); //create a response object
$cd = new CollectDtmf();
if (isset($_REQUEST['event']) && $_REQUEST['event'] == 'NewCall')   
{
        $no=$_REQUEST['cid'];
        $result = mysqli_query($conn,"select * from user where  mobile='$no' ");
        $row_cnt = $result->num_rows;
        $row = mysqli_fetch_assoc($result);
        $userid=$row['id']; 
        if ($row_cnt==0)    //check if user registered
        {
             $r->addPlayText("Sorry. This number is not registered. Thank you for calling, have a nice day");
			 $postdata = "name=Audiochat&no=".$no."&msg=register at audiochat.azurewebsites.net  ";
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
             $r->addHangup();
             $r->send();
             exit();
        }
    $cd->addPlayText("Welcome to audio chat. Press 1 to broadcast your story , 2 to listen to friends ."); // play options
    $r->addCollectDtmf($cd);
}
elseif (isset($_REQUEST['event']) && $_REQUEST['event'] == 'GotDTMF') //input taken from user
{
		$no=$_REQUEST['cid'];
		$result = mysqli_query($conn,"select * from user where  mobile='$no' ");
        $row = mysqli_fetch_assoc($result);
        $userid=$row['id'];
		$name=$row['name'];
    $choice=$_REQUEST['data'];
    if($choice=="1")
    {
        $r->addPlayText("Record your message after the beep ");
        $n=$_REQUEST['cid'];
        $r->addRecord($userid."_".md5(time()));//record message 
		$r->maxduration=15;
		$res = mysqli_query($conn,"SELECT bro_id as ID, status as status FROM friends WHERE user_id = $userid UNION SELECT user_id as ID, status FROM friends WHERE bro_id = $userid ");
				   $cnt = $res->num_rows;				   
					if ($cnt!=0) 
					{
						while( $row = mysqli_fetch_assoc($res) ) {
						 $q = mysqli_query($conn, "SELECT * FROM user WHERE id = ".$row['ID']);
						 $bro = mysqli_fetch_assoc($q);
						 $postdata = "name=Audiochat&no=".$bro['mobile']."&msg=".$name." has posted a new story.";
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
					   }
					}
				   
    }
    elseif($choice=="2")
    {
		
        //get friend's story
        $result = mysqli_query($conn,"SELECT * FROM audio WHERE user_id IN ( SELECT bro_id FROM friends  WHERE user_id=$userid UNION SELECT user_id FROM friends WHERE bro_id=$userid ) ORDER BY timestamp DESC; ");
        $row_cnt = $result->num_rows;
        if ($row_cnt==0)    //check if new story
        {
             $r->addPlayText("Sorry. There are no new stories to play right now ");
        }
        while ($arrayResult = mysqli_fetch_assoc($result))
        {
                        $r->addPlayAudio($arrayResult['url']);
						$result = mysqli_query($conn,"INSERT INTO listen (user_id,audio_id) VALUES ($userid,'".$arrayResult['id']."')");
        }
    }
	elseif($choice=="3")
    {
		$r->addPlayText("Thank you for calling audio chat ");
		$r->addHangup(); //end call
		$r->send();
		exit();
	}
    else //invalid input
    {
        $cd->addPlayText(" invalid input. Press 1 to broadcast new story , 2 to listen to friends , 3 to exit ");
        $r->addCollectDtmf($cd);
    }
}
elseif (isset($_REQUEST['event']) && $_REQUEST['event'] == 'Record') //recording completed
{
        $url=$_REQUEST['data'];
		$no=$_REQUEST['cid'];
		$result = mysqli_query($conn,"select * from user where  mobile='$no' ");
        $row = mysqli_fetch_assoc($result);
        $userid=$row['id'];
        //save url
        $result = mysqli_query($conn,"INSERT INTO audio (user_id,url) VALUES ($userid,'$url')"); //save recording url
        $cd->addPlayText("your message has been recorded successfully. Press 1 to broadcast another story , 2 to listen to friends , 3 to exit ");
        $r->addCollectDtmf($cd);    // play options again
}
else
{
    $r->addPlayText("Thank you for calling audio chat ");
    $r->addHangup(); //end call
}
$r->send();
?>
