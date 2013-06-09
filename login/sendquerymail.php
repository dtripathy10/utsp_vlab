<?php 
$name=$_POST['inputName'];
$email=$_POST['inputEmail'];
$title=$_POST['inputTitle'];
$message=$_POST['inputMessage'];
require_once "../Mail/Mail.php";
$to = "riteshsharma@iitb.ac.in";
$from = $email;
$subject = $title;
$body = $message."\n\n Thanks,\n".$name;
 
$host = "smtp-auth.iitb.ac.in";
$username = "riteshsharma";
$password = "chintu*";

$headers = array ('From' => $from,'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp', 
						array ('host' => $host,
     							'auth' => true,
     							'username' => $username,
     							'password' => $password));
 
$mail = $smtp->send($to, $headers, $body);
if (PEAR::isError($mail))
{
   	echo("<p>" . $mail->getMessage() . "</p>");
} 
else 
{
?>
<script language="JavaScript">
	alert("Your query have been sent to the development team. Thanks!");
	document.location="contact.php";
</script>
<?php 
}
		
?>