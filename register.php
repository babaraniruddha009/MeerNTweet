<!DOCTYPE html>
<?php

	require 'config/config.php';
	require 'include/form_handlers/register_handler.php';
	require 'include/form_handlers/login_handler.php';



			
?>
<html>
<head>
	<title>Welcome to ABC</title>
	<link rel="stylesheet" href="css/register_style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	
	<script  src="assets/js/register.js"></script>
</head>
<body>

	<?php
		if(isset($_POST['register_button'])){
			echo '
				<script>
					$(document).ready(function(){
						$("#first").hide();
						$("#second").show();

					});
				</script>
			';
		}
	?>

	<div class="wrapper">

		<div class="login_box" style="-webkit-box-shadow: 0 0 10px #5a5353;
        box-shadow: 0 0 10px #5a5353;">

			<div class="login_header">
			<h1>Meet&Tweet</h1>
			Login or sign up below
			</div>
			<div id="first">
				<form action="register.php" method="POST">

				<input type="email" name="log_email" placeholder="Email"  value="<?php if(isset($_COOKIE['email'])){
					echo $_COOKIE['email'];
				} ?>" required>
				<br>
				<input type="password" name="log_password" placeholder="Password"  value="<?php if(isset($_COOKIE['password'])){
					echo $_COOKIE['password'];
				} ?>" required>
				<br>
				
				<?php
					if(in_array("Email or password is incorrect.",$error_array)){
						echo "Email or password is incorrect.";
					}
				?>
				

				<p><input type="checkbox" name="remember" <?php if(isset($_COOKIE['email'])) { ?>checked <?php } ?> /> Remember me
				</p>

				

				<input type="submit" name="login_button" value="Login" style="-webkit-box-shadow: 0 0 10px #a8a0a0;
        box-shadow: 0 0 10px #a8a0a0;">
				<br>
				<a href="#" id="signup" class="signup">
				Need an account? Register here!
				</a>
			</form>
				
			</div>

			
			<div id="second">

				<form action="register.php" method="POST">
					<input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])){
						echo $_SESSION['reg_fname'];
					} ?>" required>
					<br>

					<?php
						if(in_array("Your first name must be between 2 to 25 charecters<br>", $error_array))
							echo "Your first name must be between 2 to 25 charecters<br>";
					?>


					<input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])){
						echo $_SESSION['reg_lname'];
					} ?>" required>
					<br>

					<?php
						if(in_array("Your last name must be between 2 to 25 charecters<br>", $error_array))
							echo "Your last name must be between 2 to 25 charecters<br>";
					?>

					<input type="email" name="reg_email" placeholder="Email" value="<?php if(isset($_SESSION['reg_email'])){
						echo $_SESSION['reg_email'];
					} ?>" required>
					<br>

					<input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if(isset($_SESSION['reg_email2'])){
						echo $_SESSION['reg_email2'];
					} ?>" required>
					<br>

					<?php
						if(in_array("Email already in used<br>", $error_array))
							echo "Email already in used<br>";
					
						else if(in_array("Invalid Email Format<br>", $error_array))
							echo "Invalid Email Format<br>";
					
						else if(in_array("Email dont match<br>", $error_array))
							echo "Email dont match<br>";
					?>

					<input type="Password" name="reg_password" placeholder="Password" required>
					<br>
					<input type="Password" name="reg_password2" placeholder="Confirm Password" required>
					<br>

					<?php
						if(in_array("Your password does't match<br>", $error_array))
							echo "Your password does't match<br>";
					
						else if(in_array("Your password can only contain letters and numbers<br>", $error_array))
							echo "Your password can only contain letters and numbers<br>";
					
						else if(in_array("Your password must be between 5 to 30 charecters<br>", $error_array))
							echo "Your password must be between 5 to 30 charecters<br>";
					?>

					<input type="submit" name="register_button" value="Register" style="-webkit-box-shadow: 0 0 10px #a8a0a0;
        box-shadow: 0 0 10px #a8a0a0;">
					<br>
					<?php
						if(in_array("<span style='color:#14C800;'>You're all set! Go ahead and login!</span><br>", $error_array))
							echo "<span style='color:#14C800;'>You're all set! Go ahead and login!</span><br>";
					?>
					<a href="#" id="signin" class="signin"> Already have an account? Sign in here!
					</a>
					
				</form>
			</div>
		</div>
	</div>
</body>
</html>