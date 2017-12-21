<?php
require '../../config/config.php';
include("../haeder.php");

	if(isset($_GET['post_id']))
		$post_id = $_GET['post_id'];

	if(isset($_POST['result'])) {
		if($_POST['result'] == 'true')
			// need to be updated TODO ----->
			// echo "string";
			// echo $userLoggedIn;
			// $user_obj = new User($con, $userLoggedIn);
			// echo $userLoggedIn;
			// $num_posts = mysqli_query($con, "SELECT num_posts FROM users WHERE email='$userLoggedIn'");
			// $num_posts--;
			// $update_query = mysqli_query($con, "UPDATE users SET num_posts='$num_posts' WHERE email='$userLoggedIn'");

			$query = mysqli_query($con, "DELETE FROM posts WHERE id='$post_id'");
	}

?>
