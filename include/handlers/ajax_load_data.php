<?php

include("../../config/config.php");
include("../classes/User.php");
include("../classes/message.php");

include("../classes/Notification.php");

$notifications=new Notification($con,$userLoggedIn);

$num_notifications=$notifications->getUnreadNumber();


if($num_notifications>0)
		echo $num_notifications;
?>