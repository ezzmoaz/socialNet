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
				$my_friend = new User($con, $j);
				echo '<div class="profile_info_bottom">';
				$temp = $my_friend->getFirstAndLastName();
				echo '<a href="profile.php?profile_email='. $j   . '"</a>' . $my_friend->getFirstAndLastName();
      			echo '</div>';
	}
     
?>

