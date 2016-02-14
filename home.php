<?php
	include 'php/logged.php';
	include 'php/db.php';
	$userid = $_SESSION['id'];
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>AudioChat</title>
	
	<script src="js/jquery-1.8.3.min.js"></script>

    <script>
		$(document).on('click', "#add-friend-but", function(e) {
			e.preventDefault();
			$.post("addFriend.php", { mobile : $("#Mobile-Number").val() }, function( data ) {
				if( data.length > 0 ) {
					alert(data);
					return;
				}
				$("#friend-list").prepend('<li> <img src="icon/pending.png"/>' + $("#Mobile-Number").val() + '</li>');
		location.reload(true);
			});
	});
	
	function del( aid ) {
		$.post("delaudio.php", { id: aid }, function( data ) {
			if( data == "OK" ) {
				var c = "#li-" + aid;
				$(c).remove();
			}
		location.reload(true);
		}); 
	}
	
	function accept( uid ) {
		$.post("addFriend.php", { id: uid, accept : 1 }, function( data ) {
			if( data == "OK" ) {
				var c = "#li-" + uid;
				$(c).remove();
			}
		}); 
		location.reload(true);
	}

	function deny( uid ) {
		$.post("addFriend.php", { id: uid, accept : 0 }, function( data ) {
			if( data == "OK" ) {
				var c = "#li-" + uid;
				$(c).remove();
			}
		}); 
	}
	
	</script>

    
    
        <link rel="stylesheet" href="css/home-style.css">
		<style>
			@import url(http://fonts.googleapis.com/css?family=Dosis:300|Lato:300,400,600,700|Roboto+Condensed:300,700|Open+Sans+Condensed:300,600|Open+Sans:400,300,600,700|Maven+Pro:400,700);
			@import url("http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");

			.pageHeader {
				font-family: "Open Sans";
				font-size: 14px;
				font-smoothing: antialiased;
			  width: 100%;
			  height: 50px;
			  line-height: 50px;
			  background-color: #54b9cd;
			  color: White;
			  -moz-box-sizing: border-box;
			  -webkit-box-sizing: border-box;
			  box-sizing: border-box;
			  padding: 5px 20px;
			  vertical-align: middle;
			  border-bottom: solid 2px #CCCCCC;
			}
			.pageHeader .title {
			  width: 40%;
			  float: left;
			  line-height: 50px;
			  font-size: 1.9em;
			  font-weight: 700;
			}
			.pageHeader .userPanel {
			  width: 40%;
			  float: right;
			}
			.pageHeader .userPanel i {
			  float: right;
			  line-height: 40px;
			  padding-right: 10px;
			}
			.pageHeader .userPanel .username {
			  float: right;
			  line-height: 40px;
			  padding: 0px 20px;
			  font-weight: 600;
			  font-size: 1.0em;
			}
			.pageHeader .userPanel img {
			  float: right;
			  -moz-border-radius: 5px;
			  -webkit-border-radius: 5px;
			  border-radius: 5px;
			}

			.content .list {
				padding: 0px 0px 0px 0px;
				display: inline;
				font-size: 13pt;
				
				font-family: 'Open Sans', sans-serif;
			} 
			.content ul {
				list-style-type: none;
				padding: 0px;
			}
			.content li {
				padding-bottom: 5px;
				margin-left: 10px;
			}
			.content li img {
				padding-right: 20px;
				padding-left: 20px;
			}
			
			.content p {
				font-size: 10pt;
			}
			
			.content label {
				padding-right: 15px;	
			}
			body {
			 background-image: url(http://www.ultraimg.com/images/2UeGfhZ.jpg);
			}
			a{
				color:white;
			}
		</style>
    
    
    
  </head>

  <body>

<div class="pageHeader">
	<div class="title">AudioChat</div>
    <div class="userPanel">
		<a href="logout.php"><i class="fa fa-sign-out"></i></a>
		<span class="username"> <?php echo $_SESSION['name']; ?></span>
		<img src="https://papaly.com/assets/covers/blank-profile-9567aab792e43198fb89a27c68817d53.png" width="40" height="40"/>
    </div>
</div>

<div id="wrap">
	<div id="grid">
		<div class="column column1">
		<div class="step" id="step1">
			
			<div class="title">
				<h1>Add Friend</h1>
			</div>
			<div class="modify">
			</div>
		</div>
		<div class="content" id="email">
			<form class="go-right">
				<div>
        <input name="mobile" value="" id="Mobile-Number" placeholder="Mobile Number" data-trigger="change" data-validation-minlength="1" data-required="true" data-error-message="Enter a valid mobile number."/><label for="mobile">Mobile</label>
        </div>
				<button id="add-friend-but" class="add">Add</button>
			</form>
		</div>
		<div class="step" id="step2">
			<div class="title">
				<h1>Friends List</h1>
			</div>
		</div>
		<div class="content">
		
		<div class="list">
			<ul id="friend-list" >
				<?php
				   $res = mysqli_query($conn,"SELECT bro_id as ID, status as status FROM friends WHERE user_id = $userid UNION SELECT user_id as ID, status FROM friends WHERE bro_id = $userid ");
				   $cnt = $res->num_rows;
					if ($cnt==0) 
					{
						 echo "<label>No friends added.</label>";
					}
				   while( $row = mysqli_fetch_assoc($res) ) {

					 $q = mysqli_query($conn, "SELECT * FROM user WHERE id = ".$row['ID']);
					 $bro = mysqli_fetch_assoc($q);
					 
					 if( $row['status'] == '1' ) {
						echo '<li> <img src="icon/accepted.gif"/>'.$bro['name'].'</li>';
					 }
					 else {
						echo '<li> <img src="icon/pending.png"/>'.$bro['name'].'</li>';
					 }
				   }
				?>
			</ul>
		</div>
	
		</div>
	</div>
	<div class="column">
		<div class="step" id="step3">
			<div class="title">
				<h1>Recent Activity</h1>
			</div>
			<div class="modify">
			</div>
		</div>
		<div class="content" id="shipping">
			<?php
				$res = mysqli_query($conn,"SELECT * FROM audio WHERE user_id IN ( SELECT bro_id FROM friends WHERE user_id = $userid AND status = 1 UNION SELECT user_id FROM friends WHERE bro_id = $userid AND status = 1 ) ORDER BY timestamp DESC");
				$cnt = $res->num_rows;
				if ($cnt==0) 
				{
					 echo "<label>No new story available.</label>";
				}
				while( $row = mysqli_fetch_assoc($res) ) {
					$q = mysqli_query($conn, "SELECT * FROM user WHERE id = ".$row['user_id']);
					$bro = mysqli_fetch_assoc($q);
					
					echo "<p>".$bro['name']." broadcasted a new story at ".$row['timestamp']."</p>";
				}
			?>
		</div>
	<div class="step" id="step4">
			<div class="title">
				<h1>My Recordings</h1>
			</div>
			<div class="modify">
			</div>
		</div>
		<div class="content" id="shipping">
			<?php
				$res = mysqli_query($conn,"SELECT * FROM audio WHERE user_id=$userid ORDER BY timestamp DESC");
				$i=1;
				$cnt = $res->num_rows;
				if ($cnt==0) 
				{
					 echo "<label>You have not uploaded any stories.</label>";
				}
				while( $row = mysqli_fetch_assoc($res) ) {
					echo '<li id="li-'.$row['id'].'" >';
					echo "<label>Story ".$i." at ".$row['timestamp']."</label>";
					echo "<img onclick = 'del( ".$row['id']." );' src='icon/deny.gif' title='Delete'/>";
					$i++;
				}
			?>
		
		</div>
 	</div>
 	<div class="column column3">
 		<div class="step" id="step5">
			<div class="title">
				<h1>Friend Requests</h1>
			</div>
			<div class="modify">
			</div>
		</div>
		<div class="content" id="final_products">
			<ul>
			<?php
				$res = mysqli_query($conn,"SELECT * FROM friends WHERE bro_id = $userid AND status = 0");
				$cnt = $res->num_rows;
				if ($cnt==0) 
				{
					 echo "<label>No new friend requests.</label>";
				}
				while( $row = mysqli_fetch_assoc($res) ) {
					$q = mysqli_query($conn, "SELECT * FROM user WHERE id = ".$row['user_id']);
					$bro = mysqli_fetch_assoc($q);
					echo '<li id="li-'.$bro['id'].'" >';
					echo "<label>".$bro['mobile']." (".$bro['name'].") </label>";
					echo "<img onclick = 'deny( ".$bro['id']." );' src='icon/deny.gif' title='Deny'/>";
					echo "<img onclick = 'accept( ".$bro['id']." );' src='icon/accepted.gif' title='Accept'/>";
					echo '</li>';
				}
			?>
			</ul>
		</div>
	</div>
</div>
</body>
    

    

</html>
