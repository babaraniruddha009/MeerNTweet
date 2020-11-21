<?php
include("include/header.php");
include("include/form_handlers/settings_handler.php");

?>

<div class="main_column column">
	<h4>Account Settings</h4>


	<?php
		echo "<img src='".$user['profile_pic']."' class='small_profile_pic'>";
	?>

	<br>

	<a href="upload.php">Upload new profile picture</a>
	<br>
	<br>
	<br>

	<p style="margin-bottom: 10px;font-weight: bold">Modify the values and click 'Update Details'</p>

	<?php
		$user_data_query=mysqli_query($con,"Select first_name,last_name,email from users where username='$userLoggedIn'");
		$row=mysqli_fetch_array($user_data_query);

		$first_name=$row['first_name'];
		$last_name=$row['last_name'];
		$email=$row['email'];

	?>

	<form action="Settings.php" method="POST">

		First Name: <input type='text' name="first_name" value="<?php echo $first_name ?>" id="settings_input">

		<br>

		Last Name: <input type='text' name="last_name" value="<?php echo $last_name ?>" id="settings_input">

		<br>
		
		Email: &nbsp &nbsp &nbsp &nbsp <input type='text' name="email" value="<?php echo $email ?>" id="settings_input">
		
		<br>
		<br>

		<?php
			echo $message;
		?>

		<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit">	
		<br>
		<hr>
	</form>

	<h4>Change Password</h4>
	<form action="Settings.php" method="POST">

		Old Password: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <input type='Password' name="old_password" value="" id="settings_input">

		<br>

		New Password: &nbsp &nbsp &nbsp &nbsp &nbsp <input type='Password' name="new_password_1" id="settings_input">

		<br>
		
		New Password Again: <input type='Password' name="new_password_2"
		id="settings_input">
		
		
		<br>
		<br>

		<?php
			echo $password_message;
		?>


		<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit">	
		<br>

		<hr>
		
	</form>

	<h4>Close Account</h4>

	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">	

		<br>
		<hr>
	</form>
</div>