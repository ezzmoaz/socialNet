<?php  
ob_start();//turn on output buffering -> it load all the php code and present at once
session_start();
$timezone = date_default_timezone_set("Africa/Cairo");
$con = mysqli_connect("localhost", "root", "", "SocialNet"); //Connection variable

if(mysqli_connect_errno()) 
{
    echo "Failed to connect: " . mysqli_connect_errno();
}
?>