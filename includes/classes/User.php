<?php 

/**
* 
*/
class User 
{
	private $user;
	private $con;
	
	function __construct($con, $userEmail)
	{
		$this->con = $con;
		// $user_details_query is a array of result 
		// echo $userEmail;
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE email='$userEmail'");
		if (!$user_details_query) {
		    printf("Error: %s\n", mysqli_error($con));
		    exit();
		}
		$this->user = mysqli_fetch_array($user_details_query);
	}

	public function getUserEmail(){
		return $this->user['email'];
	}

	public function getNumPosts(){
		$user_email = $this->user['email'];
		$query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE email='$user_email'");
		$row = mysqli_fetch_array($query);
		return $row['num_posts'];
	}
	public function getNumberOfFriendRequests() {
		$user_email = $this->user['email'];
		$query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_email'");
		return mysqli_num_rows($query);
	}

	public function getFirstAndLastName(){
		$user_email = $this->user['email'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE email='$user_email'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
	}

	public function getProfilePic() {
		$user_email = $this->user['email'];
		$query = mysqli_query($this->con, "SELECT profile_pic FROM users WHERE email='$user_email'");
		$row = mysqli_fetch_array($query);
		return $row['profile_pic'];
	}

	public function getFriendArray() {
		$user_email = $this->user['email'];
		$query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE email='$user_email'");
		$row = mysqli_fetch_array($query);
		return $row['friend_array'];
	}

	public function isClosed(){
		$user_email = $this->user['email'];
		$query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE email='$user_email'");
		$row = mysqli_fetch_array($query);

		if ($row['user_closed'] == "YES") {
			return true;
		}else{
			return false;
		}

	}

	public function isFriend($email_to_check) {
		$emailComma = "," . $email_to_check . ",";

		if((strstr($this->user['friend_array'], $emailComma) || $email_to_check == $this->user['email'])) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didReceiveRequest($user_from) {
		$user_to = $this->user['email'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didSendRequest($user_to) {
		$user_from = $this->user['email'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function removeFriend($user_to_remove) {
		$logged_in_user = $this->user['email'];

		$query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE email='$user_to_remove'");
		$row = mysqli_fetch_array($query);
		$friend_array_email = $row['friend_array'];
		// this replace the user which is sent to this function from friend_array with nothing
		$new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array']);
		$remove_friend = mysqli_query($this->con, "UPDATE users SET friend_array='$new_friend_array' WHERE email='$logged_in_user'");
		// this replace the user which is sent to this function from friend_array from the other users
		$new_friend_array = str_replace($this->user['email'] . ",", "", $friend_array_email);
		$remove_friend = mysqli_query($this->con, "UPDATE users SET friend_array='$new_friend_array' WHERE email='$user_to_remove'");
	}

	public function sendRequest($user_to) {
		$user_from = $this->user['email'];
		$query = mysqli_query($this->con, "INSERT INTO friend_requests VALUES('', '$user_to', '$user_from')");
	}

	public function getMutualFriends($user_to_check) {
		$mutualFriends = 0;
		$user_array = $this->user['friend_array'];
		$user_array_explode = explode(",", $user_array);

		$query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE email='$user_to_check'");
		$row = mysqli_fetch_array($query);
		$user_to_check_array = $row['friend_array'];
		$user_to_check_array_explode = explode(",", $user_to_check_array);

		foreach($user_array_explode as $i) {

			foreach($user_to_check_array_explode as $j) {

				if($i == $j && $i != "") {
					$mutualFriends++;
				}
			}
		}
		return $mutualFriends;

	}

	public function getFriends() {
		// $mutualFriends = 0;
		$user_array = $this->user['friend_array'];
		$user_array_explode = explode(",", $user_array);
		return $user_array_explode;

	}

}
 ?>