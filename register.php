<?php  
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';

?>



<!DOCTYPE html>

<html>

<script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"></script>
<head>
    <title>Welcome to SocialNet</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>


	<?php 
	if(isset($_POST['register_button'])) {
		echo '
		<script>
		$(document).ready(function() {
			$("#first").hide();
			$("#second").show();
		});
		</script>
		';
	}

	 ?>

	<div class="wrapper">
		<div class="login_box">

			<div class="login_header">
				<h1>SocialNet</h1>
				Login or Sign Up below!
			</div>
			<div id="first">
				

			    <form action="register.php" method="POST">
			        <input type="email" 
			        name="log_Email" 
			        placeholder="Email Address"
			        value="<?php if (isset($_SESSION['log_Email'])) echo $_SESSION['log_Email'];?>" 
			        required>
			        <br>
			        <input type="password" name="log_Password" placeholder="Password">
			        <br>
			        <?php if(in_array("Email or Password is incorrect<b>", $error_array)) echo "Email or Password is incorrect<b>"; ?>
			       	<br>
			        <input type="submit" name="login_button" value="Login">
			        <br>
			        <a href="#" id="signUp" class="signUp">Need an account? Register here!</a>
			    </form>

			</div>

			<div id="second">

			    <form action="register.php" method="POST">
			    <input type="text" 
			    name="reg_FName" 
			    placeholder="First Name" 
			    value="<?php if (isset($_SESSION['reg_FName'])) echo $_SESSION['reg_FName']; ?>" 
			    required>
			    <br>
			    <?php if(in_array("Your first name must be between 3 and 25 characters<br>", $error_array)) echo "Your first name must be between 3 and 25 characters<br>"; ?>
			    <input type="text" 
			    name="reg_LName" 
			    placeholder="Last Name" 
			    value="<?php if (isset($_SESSION['reg_LName'])) echo $_SESSION['reg_LName'];?>" 
			    required>
			    <br>
			    <?php if(in_array("Your Last name must be between 3 and 25 characters<br>", $error_array)) echo "Your Last name must be between 3 and 25 characters<br>"; ?>
			    <input type="text"
			    name="reg_NickName"
			    placeholder="Nickname"
			    value="<?php if (isset($_SESSION['reg_NickName'])) echo $_SESSION['reg_NickName']; ?>" >
			    <br>
			    <input type="email" 
			    name="reg_Email" 
			    placeholder="Email" 
			    value="<?php if (isset($_SESSION['reg_Email'])) echo $_SESSION['reg_Email'];?>" 
			    required>
			    <br>
			    <input type="email" 
			    name="reg_Email2" 
			    placeholder="Confirm Email" 
			    value="<?php if (isset($_SESSION['reg_Email2'])) echo $_SESSION['reg_Email2'];?>" 
			    required>
			    <br>
			    <?php if(in_array("Email already exists<br>", $error_array)) echo "Email already exists<br>";
			    else if(in_array("invalid Email format<br>", $error_array)) echo "invalid Email format<br>";
			    else if(in_array("Email Do not Match<br>", $error_array)) echo "Email Do not Match<br>"; ?>
			    <input type="password" name="reg_Password" placeholder="Password" required>
			    <br>
			    <input type="password" name="reg_Password2" placeholder="Confirm Password" required>
			    <br>
			    <?php if(in_array("Password don't match<br>", $error_array)) echo "Password don't match<br>";
			    else if(in_array("Your password contains unallowed characters<br>", $error_array)) echo "Your password contains unallowed characters<br>";
			    else if(in_array("Your Password must be between 6 and 30 characters<br>", $error_array)) echo "Your Password must be between 6 and 30 characters<br>"; ?>
			    <input type="text"
			    name="reg_PhoneNum"
			    placeholder="Phone Number"
			    value="<?php if (isset($_SESSION['reg_PhoneNum'])) echo $_SESSION['reg_PhoneNum']; ?>" >
			    <br>
			    <?php if(in_array("Your Phone Number must be between 7 and 11 number<br>", $error_array)) echo "Your Phone Number must be between 7 and 11 number<br>"; ?>
			    <input type="text"
			    name="reg_PhoneNum2"
			    placeholder="Another Phone Number"
			    value="<?php if (isset($_SESSION['reg_PhoneNum2'])) echo $_SESSION['reg_PhoneNum2']; ?>" >
			    <br>
			    <?php if(in_array("Your Phone Number 2 must be between 7 and 11 number<br>", $error_array)) echo "Your Phone Number 2 must be between 7 and 11 number<br>"; ?>
			    Gender:
			    <input type="radio" name="reg_Gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female" required>Female
			    <input type="radio" name="reg_Gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male" required>Male
			    <br>
			    
			    <input type="text"
			    name="reg_DoB"
			    placeholder="Birthdate"
			    alt="date"
			    class="IP_calendar"
			    title="Y-m-d"
			    value="<?php if (isset($_SESSION['reg_DoB'])) echo $_SESSION['reg_DoB']; ?>" 
			    required>
			    <br>
			    <input type="text"
			    name="reg_HomeTown"
			    placeholder="Home Town"
			    value="<?php if (isset($_SESSION['reg_HomeTown'])) echo $_SESSION['reg_HomeTown']; ?>" >
			    <br>
			    <?php if(in_array("Your hometown must be less than 100 characters<br>", $error_array)) echo "Your hometown must be less than 100 characters<br>"; ?>
			    Marital State:
			    <input type="radio" name="reg_MState" <?php if (isset($MState) && $MState=="single") echo "checked";?> value="single" required>Single
			    <input type="radio" name="reg_MState" <?php if (isset($MState) && $MState=="engaged") echo "checked";?> value="engaged" required>Engaged
			    <input type="radio" name="reg_MState" <?php if (isset($MState) && $MState=="married") echo "checked";?> value="married" required>Married
			    <br>
			    <textarea type="text"
			    name="reg_AboutMe"
			    placeholder="About me"
			    value="<?php if (isset($_SESSION['reg_AboutMe'])) echo $_SESSION['reg_AboutMe']; ?>" ></textarea>
			    <br>
			    <input type="submit" name="register_button" value="Register">
			    <br>
			    <?php if(in_array("<span >Sign UP is successful</span><br>", $error_array)) echo "<span >Sign UP is successful</span><br>"; ?>
			    <a href="#" id="signIn" class="signIn">Already have an account? Login here!</a>
			    </form>

		    </div>
	    </div>
	</div>

</body>
</html>
