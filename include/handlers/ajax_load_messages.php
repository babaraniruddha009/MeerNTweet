<?php

include("../../config/config.php");
include("../classes/User.php");
include("../classes/message.php");


$limit=7;

$message=new message($con,$_REQUEST['userLoggedIn']);
echo $message->getConvasDropdown($_REQUEST,$limit);



?>