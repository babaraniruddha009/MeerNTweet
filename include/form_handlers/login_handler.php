<?php 
	if(isset($_POST['login_button'])){
		$email=filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL);
		$_SESSION['log_email']=$email;

		$password=md5($_POST['log_password']);

		$check=mysqli_query($con,"SELECT * from users where email='$email' and password='$password'");
		$check_login=mysqli_num_rows($check);

		if($check_login==1){
			$row=mysqli_fetch_array($check);
			$username=$row['username'];

			$user_close=mysqli_query($con,"Select * from users where email='$email' and user_closed='yes'");

			if(mysqli_num_rows($user_close)==1){
				$reopen_account=mysqli_query($con,"update users set user_closed='no' where email='$email'");
			}

			if(!empty($_POST["remember"])){
				setcookie("email",$email,time()+(10*365*24*60*60));
				setcookie("password",$_POST['log_password'],time()+(10*365*24*60*60));

				
			}else{
				if(isset($_COOKIE['email'])){
					setcookie("email","");
				}
				if(isset($_COOKIE['password'])){
					setcookie("password","");
				}
			}
			$_SESSION['username']=$username;
			header('Location:index.php');
			exit();
		}else{
			array_push($error_array,"Email or password is incorrect.");
		}
	}
?>