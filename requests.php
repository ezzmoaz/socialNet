<?php
include("includes/header.php"); //Header 

echo $_POST["user"];
echo $_POST["accept"];

$user_from = $_POST["user"]; 
if(isset($_POST["accept"])) {

	$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE email='$userLoggedIn'");
	$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$userLoggedIn,') WHERE email='$user_from'");

	$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
	echo "You are now friends!";
	header("Location: requests.php");
}

else if($_POST['accept_request'.$user_from] == "Ignore") {
	$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
	echo "Request ignored!";
	header("Location: requests.php");
}




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
			echo "seeedak yalla" . $_POST['amr'];
			echo "something";
			var_dump($_POST);
			

	?>
			<form action="requests.php" method="POST">
				<input type="submit" name="accept" id="accept_button" value="Accept">
				<input name="user" value="<?php echo $user_from; ?>" type="hidden" />
				<input type="submit" name="ignore" id="ignore_button" value="Ignore">
			</form>

	<?php



		}

	}

	?>


</div>