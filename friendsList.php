<?php
include("includes/header.php");

if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	$id = 0;
}

?>


<?php

    $logged_in_user_obj = new User($con, $userLoggedIn);

    $user_freind_array = $logged_in_user_obj->getFriends($userLoggedIn);
    foreach($user_freind_array as $j) {
			if ($j != ""){ ?>

					<?php
				$my_friend = new User($con, $j);
				echo '<div class="profile_info_bottom">';
				$temp = $my_friend->getFirstAndLastName();
				//echo '<a href="profile.php?profile_email='. $j   . '"</a>' . $my_friend->getFirstAndLastName();
      			echo '</div>';

					?>


					<div class="user_details column">
						<a href="<?php echo "profile.php?profile_email=" . $my_friend->getUserEmail(); ?> "><img src="<?php echo $my_friend->getProfilePic(); ?>"></a>

						<div class="user_details_left_right">



							<a href="<?php echo "profile.php?profile_email=" . $my_friend->getUserEmail(); ?> ">
							<?php
							echo $my_friend->getFirstAndLastName(). "<br>";
							?>
							</a>

							<?php
							echo "Posts: " . $my_friend->getNumPosts() . "<br>";
							//echo "Likes: " . $my_friend->;
							if($logged_in_user_obj->isFriend($my_friend->getUserEmail())) {
 					?>

					<form action="friendsList.php" method="POST">
					<input type="hidden" name="friend" value="<?php echo $my_friend->getUserEmail(); ?>"  />
					<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>
					</form>
					<?php
 				}

							?>
						</div>
					</div>

					<?php
	}
}
if(isset($_POST['remove_friend'])) {
	$friend = strip_tags($_POST['friend']);
	echo $friend ;
$logged_in_user_obj->removeFriend($friend);
header("Location: friendsList.php" . $email);
}
?>
