<?php
include("includes/header.php"); //Header

?>

<div class="main_column column" id="main_column">

	<h4>Friend Requests</h4>

	<?php
	// echo $userLoggedIn;
	$query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'");
	if(mysqli_num_rows($query) == 0)
		echo "You have no friend requests at this time!";
	else {
		while($row = mysqli_fetch_array($query)) {
			$user_from = $row['user_from'];
			$user_from_obj = new User($con, $user_from);

			echo $user_from_obj->getFirstAndLastName() . " sent you a friend request!";

			$user_from_friend_array = $user_from_obj->getFriendArray();
			// echo $user_from;
			// echo !isset($_POST['accept_request' . $user_from]);

			// echo "something";
			//var_dump($_POST);
	?>
			<form action="requests.php" method="POST">
				<input type="submit" name="accept" id="accept_button" value="Accept">
				<input type="hidden" name="user" value="<?php echo $user_from; ?>"  />
				<input type="submit" name="ignore" id="ignore_button" value="Ignore">
			</form>

	<?php

	//$user_from = $_POST["user"];
	if(isset($_POST["accept"])) {
		if ($_POST["user"] == $user_from ){
		$user_from = strip_tags($_POST['user']);

		$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE email='$userLoggedIn'");
		$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$userLoggedIn,') WHERE email='$user_from'");

		$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
		echo "You are now friends!";
		header("Location: requests.php");
						$notification = new Notification($con, $userLoggedIn);
            $notification->insertNotification(' ', $user_from, "friend_request_accept");
	}
}

	else if(isset($_POST["ignore"])) {
		$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
		echo "Request ignored!";
		header("Location: requests.php");
		$notification = new Notification($con, $userLoggedIn);
		$notification->insertNotification(' ', $user_from, "friend_request_ignored");
	}

}


}
?>




</div>
