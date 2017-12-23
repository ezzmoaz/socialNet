<?php
require '../../config/config.php';
include("../haeder.php");

	if(isset($_GET['post_id']))
		$post_id = $_GET['post_id'];

	if(isset($_POST['result'])) {
		if($_POST['result'] == 'true')
			$post_added_by = mysqli_query($con, "SELECT * FROM posts WHERE id='$post_id'");
			$mail = mysqli_fetch_array($post_added_by);
			$temp = $mail["added_by"];
			$num_of_posts = mysqli_query($con, "SELECT * FROM users WHERE email = '$temp'");
			$numpost = mysqli_fetch_array($num_of_posts);
			$temp2 = $numpost["num_posts"];
			$temp2 = $temp2 - 1; 
			$query = mysqli_query($con, "DELETE FROM posts WHERE id='$post_id'");
			$userquery = mysqli_query($con, "UPDATE users  SET num_posts = '$temp2' WHERE email = '$temp'");
	}

?>
