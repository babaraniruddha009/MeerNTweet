<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<style type="text/css">
		*{
			margin-top: 3px;
			font-family: Arial,Melvetica, Sans-serif

		}
		body{
			background-color:#fff;

		}
		form{
			position: absolute;
			top:0;
		}
	</style>

	<?php
		require 'config/config.php';
		include("include/classes/User.php");
		include("include/classes/Post.php");
	include("include/classes/Notification.php");

		if(isset($_SESSION['username'])){
			$userLoggedIn=$_SESSION['username'];
			$user_details_query=mysqli_query($con,"Select * from users where username='$userLoggedIn'");
			$user=mysqli_fetch_array($user_details_query);
		}
		else{
			header("Location:register.php");
		}

		if(isset($_GET['post_id'])){
			$post_id=$_GET['post_id'];
		}

		$get_likes=mysqli_query($con,"Select likes,added_by from posts where id='$post_id'");
		$row=mysqli_fetch_array($get_likes);
		$total_likes=$row['likes'];
		$user_liked=$row['added_by'];

		$user_details_query=mysqli_query($con,"Select * from users where username='$user_liked'");
		$row=mysqli_fetch_array($user_details_query);
		$total_user_likes=$row['num_likes'];

		//like button
		if(isset($_POST['like_button'])){
			$total_likes++;

			$query=mysqli_query($con,"Update posts set likes='$total_likes' where id='$post_id'");
			$total_user_likes++;
			$user_likes=mysqli_query($con,"Update users set num_likes='$total_user_likes' where username='$user_liked'");

			$insert_user=mysqli_query($con,"Insert into likes values('','$userLoggedIn','$post_id')");


			if($user_liked!=$userLoggedIn){
				$notification=new Notification($con,$userLoggedIn);
				$notification->insertNotification($post_id,$user_liked,"like");
			}

		}
		//unlike

		if(isset($_POST['unlike_button'])){
			$total_likes--;

			$query=mysqli_query($con,"Update posts set likes='$total_likes' where id='$post_id'");
			$total_user_likes--;
			$user_likes=mysqli_query($con,"Update users set num_likes='$total_user_likes' where username='$user_liked'");

			$insert_user=mysqli_query($con,"Delete from likes where username='$userLoggedIn' and post_id='$post_id'");
			
		}

		//check previous like

		$check_query=mysqli_query($con,"Select * from likes where username='$userLoggedIn' and post_id='$post_id'");

		$num_rows=mysqli_num_rows($check_query);
		if($num_rows>0){
			echo '<form action="like.php?post_id='.$post_id.'" method="POST">
			<input type="submit" class="comment_like" name="unlike_button" value="unlike">
			<div class="like_value">
				'.$total_likes.' Likes
			</div>

			</form>';
		}else{
			echo '<form action="like.php?post_id='.$post_id.'" method="POST">
			<input type="submit" class="comment_like" name="like_button" value="like">
			<div class="like_value">
				'.$total_likes.' Likes
			</div>

			</form>';
		}

	?>
</body>
</html>