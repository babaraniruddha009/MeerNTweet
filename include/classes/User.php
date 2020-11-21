<?php
class User{


	private $user;
	private $con;

	public function __construct($con,$user){
		$this->con=$con;
		$user_details_query=mysqli_query($con,"Select * from users where username='$user'");
		$this->user=mysqli_fetch_array($user_details_query);

	}

	public function getUsername(){


		return $this->user['username'];
	}

	public function getNumberOfFriendRequests(){
		$username=$this->user['username'];
		$query=mysqli_query($this->con,"Select * from friend_requests where user_to='$username'");

		return mysqli_num_rows($query);
	}

	public function getNumPosts(){
		$username=$this->user['username'];
		$query=mysqli_query($this->con,"Select num_post from users where username='$username' and deleted='no'");

		$row=mysqli_fetch_array($query);
		return $row['num_post'];
	}

	public function getFirstAndLastName(){

		$username=$this->user['username'];
		$query=mysqli_query($this->con,"Select first_name,last_name from users where username='$username'");
		$row=mysqli_fetch_array($query);

		return $row['first_name']." ".$row['last_name'];
	}

	public function isClosed(){
		$username =$this->user['username'];
		$query=mysqli_query($this->con,"Select user_closed from users where username='$username'");
		$row=mysqli_fetch_array($query);

		if($row['user_closed']=='yes')
			return true;
		else
			return false;

	}

	public function isFriend($username_to_check){
		$usernameComa=",".$username_to_check.",";
		if((strstr($this->user['friend_array'],$usernameComa)|| $username_to_check==$this->user['username'] )){
			return true;
		}
		else{
			return false;
		}
	}

	public function getProfilePic(){

		$username=$this->user['username'];
		$query=mysqli_query($this->con,"Select profile_pic from users where username='$username'");
		$row=mysqli_fetch_array($query);

		return $row['profile_pic'];
	}

	public function getFriendArray(){

		$username=$this->user['username'];
		$query=mysqli_query($this->con,"Select friend_array from users where username='$username'");
		$row=mysqli_fetch_array($query);

		return $row['friend_array'];
	}
	public function didReceiveRequest($user_from){
			$user_to =$this->user['username'];
			$check_request_query=mysqli_query($this->con,"Select * from friend_requests where user_to='$user_to' and user_from='$user_from'");
			if(mysqli_num_rows($check_request_query)>0){
				return true;
			}else{
				return false;
			}
	}

	public function didSendRequest($user_to){
			$user_from =$this->user['username'];
			$check_request_query=mysqli_query($this->con,"Select * from friend_requests where user_to='$user_to' and user_from='$user_from'");
			if(mysqli_num_rows($check_request_query)>0){
				return true;
			}else{
				return false;
			}
	}

	public function removeFriend($user_to_remove){
		$logged_in_user=$this->user['username'];
		$query=mysqli_query($this->con,"Select friend_array from users where username='$user_to_remove'");

		$row=mysqli_fetch_array($query);
		$friend_array_username=$row['friend_array'];

		$new_friend_array=str_replace($user_to_remove.",", "", $this->user['friend_array']);

		$remove_friend=mysqli_query($this->con,"Update users set friend_array='$new_friend_array' where username='$logged_in_user'" );

		$new_friend_array=str_replace( $this->user['username'].",", "",$friend_array_username);

		$remove_friend=mysqli_query($this->con,"Update users set friend_array='$new_friend_array' where username='$user_to_remove'" );

	}

	public function sendRequest($user_to){
		$user_from=$this->user['username'];
		$query=mysqli_query($this->con,"insert into friend_requests values('','$user_to','$user_from')");
	}

	public function getMutualFriends($user_to_check){
		$mutualFriend=0;
		$user_array=$this->user['friend_array'];
		$user_array_explode=explode(",",$user_array);

		$query=mysqli_query($this->con,"Select friend_array from users where username='$user_to_check'");
		$row=mysqli_fetch_array($query);
		$user_to_check_array=$row['friend_array'];
		$user_to_check_array_explode=explode(",",$user_to_check_array);

		foreach ($user_array_explode as $i) {
			# code...
			foreach ($user_to_check_array_explode as $j) {
				# code...
				if($i==$j && $i!=""){
					$mutualFriend++;
				}

			}
		}

		return $mutualFriend;
	}



}
?>
