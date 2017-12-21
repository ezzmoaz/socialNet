<?php  

//Declaring variables to prevent errors
$fName = "";//
$lName = "";//
$nickname = "";
$password = "";
$password2 = "";
$phoneNum = "";
$phoneNum2 = "";
$email = "";
$email2 = "";
$gender = "";
$DoB = "";
$homeTown = "";
$MState = "";
$aboutMe = "";
$date = "";
$error_array = array();

if(isset($_POST['register_button'])){

    //Transfring the values from HTML form to PHP variables
    //First Name
    $fName = strip_tags($_POST['reg_FName']);//strip_tags -> prevent something like this <a>moaz<a>
    $fName = str_replace(' ','', $fName);//str_replace -> replace " " with "" remove spaces
    $fName = ucfirst(strtolower($fName)); // make the char is uppercase and the rest is lowercase
    $_SESSION['reg_FName'] = $fName;// store the variable into session variable
    //Last Name
    $lName = strip_tags($_POST['reg_LName']);//strip_tags -> prevent something like this <a>moaz<a>
    $lName = str_replace(' ','', $lName);//str_replace -> replace " " with "" remove spaces
    $lName = ucfirst(strtolower($lName)); // make the char is uppercase and the rest is lowercase
    $_SESSION['reg_LName'] = $lName;// store the variable into session variable
    //Nickname
    $nickname = strip_tags($_POST['reg_NickName']);//strip_tags -> prevent something like this <a>moaz<a>
    $nickname = ucfirst(strtolower($nickname)); // make the char is uppercase and the rest is lowercase
    $_SESSION['reg_NickName'] = $nickname;// store the variable into session variable
    //Email
    $email = strip_tags($_POST['reg_Email']);//strip_tags -> prevent something like this <a>moaz<a>
    $email = str_replace(' ','', $email);//str_replace -> replace " " with "" remove spaces
    $email = strtolower($email); // make the char is uppercase and the rest is lowercase
    $_SESSION['reg_Email'] = $email;// store the variable into session variable
    //Email2
    $email2 = strip_tags($_POST['reg_Email2']);//strip_tags -> prevent something like this <a>moaz<a>
    $email2 = str_replace(' ','', $email2);//str_replace -> replace " " with "" remove spaces
    $email2 = strtolower($email2); // make the char is uppercase and the rest is lowercase
    $_SESSION['reg_Email2'] = $email2;// store the variable into session variable
    //Phone Number
    $phoneNum = strip_tags($_POST['reg_PhoneNum']);//strip_tags -> prevent something like this <a>moaz<a>
    $phoneNum = str_replace(' ','', $phoneNum);//str_replace -> replace " " with "" remove spaces
    $_SESSION['reg_PhoneNum'] = $phoneNum;// store the variable into session variable
    //Phone Number 2
    $phoneNum2 = strip_tags($_POST['reg_PhoneNum2']);//strip_tags -> prevent something like this <a>moaz<a>
    $phoneNum2 = str_replace(' ','', $phoneNum2);//str_replace -> replace " " with "" remove spaces
    $_SESSION['reg_PhoneNum2'] = $phoneNum2;// store the variable into session variable
    //Password
    $password = strip_tags($_POST['reg_Password']);//strip_tags -> prevent something like this <a>moaz<a>
    //Password2
    $password2 = strip_tags($_POST['reg_Password2']);//strip_tags -> prevent something like this <a>moaz<a>
    //Date
    $date = date("Y-m-d");//Current Date
    //Gender
    $gender = strip_tags($_POST['reg_Gender']);//strip_tags -> prevent something like this <a>moaz<a>
    $gender = ucfirst(strtolower($gender)); // make the char is uppercase and the rest is lowercase
    //DoB
    $DoB = date("Y-m-d");//Current Date
    $DoB = strip_tags($_POST['reg_DoB']);//strip_tags -> prevent something like this <a>moaz<a>
    $_SESSION['reg_DoB'] = $DoB;// store the variable into session variable
    //HomeTown
    $homeTown = strip_tags($_POST['reg_HomeTown']);//strip_tags -> prevent something like this <a>moaz<a>
    $_SESSION['reg_HomeTown'] = $homeTown;// store the variable into session variable
    //Marital Status
    $MState = $_POST['reg_MState'];//strip_tags -> prevent something like this <a>moaz<a>
    $MState = ucfirst(strtolower($MState)); // make the char is uppercase and the rest is lowercase
    //About Me
    $aboutMe = strip_tags($_POST['reg_AboutMe']);//strip_tags -> prevent something like this <a>moaz<a>
    $_SESSION['reg_AboutMe'] = $aboutMe;// store the variable into session variable

    if ($email == $email2) {
       //Check if email is a valid email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            //chech if email exisit
            $email_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
            //count the number of rows returned if > 0 = there is already one exists
            $num_rows = mysqli_num_rows($email_check);
            if ($num_rows > 0 ) {
                array_push($error_array, "Email already exists<br>");
            }

        }else{
            array_push($error_array, "invalid Email format<br>");
        }
    }else{
        array_push($error_array, "Email Do not Match<br>");
    }

    if (strlen($fName) > 25 || strlen($fName) < 3) {
        array_push($error_array, "Your first name must be between 3 and 25 characters<br>");
    }
    if (strlen($lName) > 25 || strlen($lName) < 3) {
        array_push($error_array, "Your Last name must be between 3 and 25 characters<br>");
    }
    if ($password != $password2) {
        array_push($error_array, "Password don't match<br>");
    }else{
        if(preg_match('/[^A-Za-z0-9]/', $password)){
            array_push($error_array, "Your password contains unallowed characters<br>");
        }
    }
    if (strlen($password) > 30 || strlen($password) < 6){
        array_push($error_array, "Your Password must be between 6 and 30 characters<br>");
    }
    if ((strlen($phoneNum) > 11 || strlen($phoneNum) < 7 ) && strlen($phoneNum) != 0){
        array_push($error_array, "Your Phone Number must be between 7 and 11 number<br>");
    }
    if ((strlen($phoneNum2) > 11 || strlen($phoneNum2) < 7 ) && strlen($phoneNum2) != 0){
        array_push($error_array, "Your Phone Number 2 must be between 7 and 11 number<br>");
    }
    if (strlen($homeTown) > 100){
        array_push($error_array, "Your hometown must be less than 100 characters<br>");
    }
    
    if (empty($error_array)){
        $password = md5($password); // Encrypt the password before sending to Database
        if ($nickname == "") $nickname = $fName . " " . $lName; // create a Nickname if there is no Nickname -> "fname lname"
        // Profile Pic picking
        $rand = rand(1,4);
        $profilePic = "assets/images/profile_pics/defaults/boy_" . $rand . ".png";
        if ($gender == "Female") $profilePic = "assets/images/profile_pics/defaults/girl_" . $rand . ".png";

        
        //INSERT INTO `users` VALUES (`id`, `first_name`, `last_name`, `nickname`, `email`, `password`, `phone_Num`, `phone_Num2`, `gender`, `DoB`, `profile_pic`, `hometown`, `marital_state`, `about_me`, `friend_array`, `user_closed`, `num_posts`, `num_likes`, `signup_date`)
        // INSERT INTO `users`(`email`, `first_name`, `last_name`, `nickname`, `password`, `gender`, `DoB`, `profile_pic`, `hometown`, `marital_state`, `about_me`, `friend_array`, `user_closed`, `num_posts`, `num_likes`, `signup_date`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],[value-15],[value-16])
        $query = mysqli_query($con, "INSERT INTO `users` VALUES ('$email', '$fName', '$lName', '$nickname', '$password', '$gender', '$DoB', '$profilePic', '$homeTown', '$MState', '$aboutMe', ',', 'NO', '0', '0', '$date')");

        array_push($error_array, "<span >Sign UP is successful</span><br>");

        //Delete all session variables to disaber after signup
        $_SESSION['reg_FName'] = "";
        $_SESSION['reg_LName'] = "";
        $_SESSION['reg_NickName'] = "";
        $_SESSION['reg_Email'] = "";
        $_SESSION['reg_Email2'] = "";
        $_SESSION['reg_PhoneNum'] = "";
        $_SESSION['reg_PhoneNum2'] = "";
        $_SESSION['reg_DoB'] = "";
        $_SESSION['reg_HomeTown'] = "";
        $_SESSION['reg_AboutMe'] = "";
        $fName = "";//
$lName = "";//
$nickname = "";
$password = "";
$password2 = "";
$phoneNum = "";
$phoneNum2 = "";
$email = "";
$email2 = "";
$gender = "";
$DoB = "";
$homeTown = "";
$MState = "";
$aboutMe = "";
$date = "";


    
    }

    


}

?>