<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/Notification.php");


$notification = new Notification($con, $_SESSION['Email']);
echo $notification->getUnreadNumber();

?>