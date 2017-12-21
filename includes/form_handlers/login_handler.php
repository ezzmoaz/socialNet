<?php 

if (isset($_POST['login_button'])) {
	
	$email = filter_var($_POST['log_Email'], FILTER_SANITIZE_EMAIL); // sanitize email

	$_SESSION['log_Email'] = $email; // stroe email in session variable
	$password = md5($_POST['log_Password']); // get password

	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");

	$check_login_query = mysqli_num_rows($check_database_query);
	
	if ($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$userEmail = $row['email'];


		$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='YES'");
		if (mysqli_num_rows($user_closed_query) == 1) {
			$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='NO' WHERE email='$email'");
		}

		$_SESSION['Email'] = $userEmail;
		header("Location: index.php");
		exit();
	}else{
		array_push($error_array, "Email or Password is incorrect<b>");
	}
}



 ?>