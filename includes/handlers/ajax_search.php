<?php
include("../../config/config.php");
include("../../includes/classes/User.php");

$query = $_POST['query'];
$userLoggedIn =$_POST['userLoggedIn'];
//split the elements to array
$names = explode(" ",  $query);

//TODO ->
// a. Full email -> Done
// b. First ,last names -> Done
// c. Hometown
// d. Part of caption from all posts he has posted before

$flag = false;
// if query contains '_' assum that serching for email
if(strpos($query, "_") !== false || strpos($query, "@") !== false ) {// === compare the type,  strpos return the index  of the chosen char else return false
	$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE email LIKE '$query%' AND user_closed='NO' LIMIT 8");
}
else if(count($names) == 2) {// if there are 2 name assume that they searching for First and last name
	$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' AND last_name LIKE '%$names[1]%') AND user_closed='NO' LIMIT 8");
}
else {// if there are 2 name assume that they searching for First or last name
	$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='NO' LIMIT 8");
	$counter = mysqli_num_rows($usersReturned);
	if ($counter != 0 ) {
		$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE hometown LIKE '$query%' AND user_closed='NO' LIMIT 8");
		$counter = mysqli_num_rows($usersReturned);
		if ($counter == 0 ) {
			$usersReturned = mysqli_query($con, "SELECT * FROM posts WHERE body LIKE '$query%' AND user_closed='NO' AND is_public='YES' LIMIT 8");
			$flag = true;
		}
	}
	// $usersReturned = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='NO' LIMIT 3 UNION ALL SELECT * FROM users WHERE hometown LIKE '$query%' AND user_closed='NO' LIMIT 3 UNION ALL SELECT * FROM posts WHERE body LIKE '$query%' AND user_closed='NO' AND is_public='YES' LIMIT 3");
	// // $num_rows = mysqli_num_rows($usersReturned);
	// if(!$usersReturned){
	// 	$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='NO' LIMIT 8");
	// }
}
if($query != "") {
	while($row = mysqli_fetch_array($usersReturned)) {
		if ($flag) {
			echo "<div class='resultDisplay'>
					it is a spost
				</div>";;
		}else{
		$user = new User($con, $userLoggedIn);
		if($row['email'] != $userLoggedIn) {
			$mutual_friends = $user->getMutualFriends($row['email']) . " friends in common";
		}
		else {
			$mutual_friends = "";
		}

		if($user->isFriend($row['email'])) {
			echo "<div class='resultDisplay'>
					<a href='messages.php?u=" . $row['email'] . "' style='color: #000'>
						<div class='liveSearchProfilePic'>
							<img src='". $row['profile_pic'] . "'>
						</div>

						<div class='liveSearchText'>
							".$row['first_name'] . " " . $row['last_name']. "
							<p style='margin: 0;'>". $row['email'] . "</p>
							<p id='grey'>".$mutual_friends . "</p>
						</div>
					</a>
				</div>";

		}
		}
		


	}
}
 ?>
