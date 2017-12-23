	<?php

	include("includes/header.php");

	if(isset($_GET['q'])) {
		$query = $_GET['q'];
	}
	else {
		$query = "";
	}

	if(isset($_GET['type'])) {
		$type = $_GET['type'];
	}
	else {
		$type = "none";
	}
	?>

	<div class="main_column column" id="main_column">

		<?php 
		$a = "";

		if($query == ""){
			echo "You must enter something in the search box.";
		}else {
			$names = explode(" ", $query);
				// If query contains an underscore, assume user is searching for s
			if($type == "email") {
				$usersReturned1 = mysqli_query($con, "SELECT * FROM users WHERE email LIKE '$query%' AND user_closed='NO' LIMIT 8");
			}else if ($type == "name"){
				$usersReturned2 = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='NO' LIMIT 8");
			}else if ($type == "HomeTown"){
				$usersReturned3 = mysqli_query($con, "SELECT * FROM users WHERE hometown LIKE '$query%' AND user_closed='NO' LIMIT 8");
			}else if($type == "post"){
				$usersReturned4 = mysqli_query($con, "SELECT * FROM posts WHERE body LIKE '$query%' AND user_closed='NO' AND is_public='YES' LIMIT 8");
			}
			// If there are two words, assume they are first and last names respectively
			else {
				

				$usersReturned1 = mysqli_query($con, "SELECT * FROM users WHERE email LIKE '$query%' AND user_closed='NO' LIMIT 8");
				$usersReturned2 = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='NO' LIMIT 8");
				$usersReturned3 = mysqli_query($con, "SELECT * FROM users WHERE hometown LIKE '$query%' AND user_closed='NO' LIMIT 8");
				$usersReturned4 = mysqli_query($con, "SELECT * FROM posts WHERE body LIKE '$query%' AND user_closed='NO' AND is_public='YES' LIMIT 8");
			}

			// Check if results were found 



			echo "<p id='grey'>Try searching for:</p>";

			echo "<a href='search.php?q=" . $query ."&type=name'>Names</a>, <a href='search.php?q=" . $query ."&type=email'>Emails</a>, <a href='search.php?q=" . $query ."&type=HomeTown'>HomeTown</a>,  <a href='search.php?q=" . $query ."&type=post'>Posts</a><br><br><hr id='search_hr'> ";
			// $names = explode(" ",  $query);
			// $usersReturned1 = mysqli_query($con, "SELECT * FROM users WHERE email LIKE '$query%' AND user_closed='NO' LIMIT 8");
			// $usersReturned2 = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='NO' LIMIT 8");
			// $usersReturned3 = mysqli_query($con, "SELECT * FROM users WHERE hometown LIKE '$query%' AND user_closed='NO' LIMIT 8");
			// $usersReturned4 = mysqli_query($con, "SELECT * FROM posts WHERE body LIKE '$query%' AND user_closed='NO' AND is_public='YES' LIMIT 8");
			if($query != "") {
			// $a = "";
				if ($type == "email" || $type == "none"){
						while($row = mysqli_fetch_array($usersReturned1)) {
						$user = new User($con, $userLoggedIn);
						if($row['email'] != $userLoggedIn) {
							$mutual_friends = $user->getMutualFriends($row['email']) . " friends in common";
						}
						else {
							$mutual_friends = "";
						}


						$a = $a .  "<div class='search_result'>
						<div class='searchPageFriendButtons'>
						</div>


						<div class='result_profile_pic'>
						<a href='profile.php?profile_email=" . $row['email'] ."' ><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
						</div>

						<a href='profile.php?profile_email=" . $row['email'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
						<p id='grey'> " . $row['email'] ."</p>
						</a>
						<br>
						" . $mutual_friends ."<br>

						</div>
						<hr id='search_hr'>";;

					}
				}
				
				if ($type == "name" || $type == "none"){
					while($row3 = mysqli_fetch_array($usersReturned2)) {
						$user = new User($con, $userLoggedIn);
						if($row3['email'] != $userLoggedIn) {
							$mutual_friends = $user->getMutualFriends($row3['email']) . " friends in common";
						}
						else {
							$mutual_friends = "";
						}


						$a = $a . "<div class='search_result'>
						<div class='searchPageFriendButtons'>
						</div>


						<div class='result_profile_pic'>
						<a href='profile.php?profile_email=" . $row3['email'] ."' ><img src='". $row3['profile_pic'] ."' style='height: 100px;'></a>
						</div>

						<a href='profile.php?profile_email=" . $row3['email'] ."'> " . $row3['first_name'] . " " . $row3['last_name'] . "
						<p id='grey'> " . $row3['email'] ."</p>
						</a>
						<br>
						" . $mutual_friends ."<br>

						</div>
						<hr id='search_hr'>";;


					}
				}

				if ($type == "HomeTown" || $type == "none"){
					while($row4 = mysqli_fetch_array($usersReturned3)) {
						$user = new User($con, $userLoggedIn);
						if($row4['email'] != $userLoggedIn) {
							$mutual_friends = $user->getMutualFriends($row4['email']) . " friends in common";
						}
						else {
							$mutual_friends = "";
						}

						// if($user->isFriend($row['email'])) {
						$a = $a . "<div class='search_result'>
						<div class='searchPageFriendButtons'>
						</div>


						<div class='result_profile_pic'>
						<a href='profile.php?profile_email=" . $row4['email'] ."' ><img src='". $row4['profile_pic'] ."' style='height: 100px;'></a>
						</div>

						<a href='profile.php?profile_email=" . $row4['email'] ."'> " . $row4['first_name'] . " " . $row4['last_name'] . "
						<p id='grey'> " . $row4['email'] ."</p>
						</a>
						<br>
						" . $mutual_friends ."<br>

						</div>
						<hr id='search_hr'>";;


					}

				}

				if ($type == "post" || $type == "none"){
					while($row2 = mysqli_fetch_array($usersReturned4)) {
						$user = new User($con, $row2['added_by']);
						$a = $a . "<div class='resultDisplay'><p></p>
						<a href='post.php?id=" . $row2['id']. "' style='color: #000'>
						<div class='liveSearchProfilePic'>
						<img src='". $user->getProfilePic() . "'>
						</div>

						<div class='liveSearchText'>
						".$user->getFirstAndLastName(). "
						<p id='grey'> Post : ".$row2['body'] . "</p>
						</div>
						</a>
						</div>";

					
					}
				}

				echo $a;

			
			}
		

		
		}

		
		


		?>



	</div>