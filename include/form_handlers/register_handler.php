
<?php
	$fname="";
	$lname="";
	$em="";
	$em2="";
	$password="";
	$password2="";
	$date="";
	$error_array=array();



	if(isset($_POST['register_button'])){
		$fname=strip_tags($_POST['reg_fname']);
		$fname=str_replace(' ', '', $fname);
		$fname=ucfirst(strtolower($fname));

		$_SESSION['reg_fname']=$fname;

		$lname=strip_tags($_POST['reg_lname']);
		$lname=str_replace(' ', '', $lname);
		$lname=ucfirst(strtolower($lname));

		$_SESSION['reg_lname']=$lname;

		$em=strip_tags($_POST['reg_email']);
		$em=str_replace(' ', '', $em);
		$em=strtolower($em);

		$_SESSION['reg_email']=$em;

		$em2=strip_tags($_POST['reg_email2']);
		$em2=str_replace(' ', '', $em2);
		$em2=strtolower($em2);

		$_SESSION['reg_email2']=$em2;

		$password=strip_tags($_POST['reg_password']);

		$password2=strip_tags($_POST['reg_password2']);
		
		$date=date("Y-m-d");

		if($em==$em2){
			if(filter_var($em,FILTER_VALIDATE_EMAIL)){

				$em=filter_var($em,FILTER_VALIDATE_EMAIL);

				$e_check=mysqli_query($con,"Select email from users where email='$em'");
				$num_rows=mysqli_num_rows($e_check);
				if($num_rows>0){
					array_push($error_array,"Email already in used<br>");
				}

			}else{
				array_push($error_array,"Invalid Email Format<br>");
				
			}

		}else{
			array_push($error_array,"Email dont match<br>");
		
		}

		if(strlen($fname)>25 || strlen($fname)<2){
			array_push($error_array,"Your first name must be between 2 to 25 charecters<br>");
		
		}
		if(strlen($lname)>25 || strlen($lname)<2){
			array_push($error_array,"Your last name must be between 2 to 25 charecters<br>");
	

		}
		if($password!=$password2){
			array_push($error_array,"Your password does't match<br>");
		}
		else{
			if(preg_match('/[^A-Za-z0-9]/', $password)){
				array_push($error_array,"Your password can only contain letters and numbers<br>");
			}

		}

		if(strlen($password>30)||strlen($password)<5){
			array_push($error_array,"Your password must be between 5 to 30 charecters<br>");
		}

		if(empty($error_array)){
			$password=md5($password); //Encrypt password.
			//Generate username

			$username=strtolower($fname."_".$lname);
			$check_username_query=mysqli_query($con,"Select username from users where username='$username'");
			$i=0;
			//
			while (mysqli_num_rows($check_username_query)!=0) {
				
				$i++;
				$username=$username."_".$i;
				$check_username_query=mysqli_query($con,"Select username from users where username='$username'");
			}

			$rand=rand(1,2);
			if($rand==1){
				
					$profile_pic="assets/images/profile_pics/defaults/head_deep_blue.png";
			}
			else{
					$profile_pic="assets/images/profile_pics/defaults/head_emerald.png";
			}
			
			$query=mysqli_query($con,"Insert into users values('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");
			array_push($error_array,"<span style='color:#14C800;'>You're all set! Go ahead and login!</span><br>");
			$_SESSION['reg_fname']="";
			$_SESSION['reg_lname']="";
			$_SESSION['reg_email']="";
			$_SESSION['reg_email2']="";
			
		}

	}
?>