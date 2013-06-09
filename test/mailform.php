<?php
$to = "dtripathy10@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "dtripathy10@gmail.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?> 