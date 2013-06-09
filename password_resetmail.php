<?php 
include_once("util/system.php");
$credential=$_POST['inputcredential'];

require_once "Mail/Mail.php";
selectDatabase();
$sql = "select UserName,Password,EmailId,fname from UserMaster where UserName ='".$credential."' || EmailId='".$credential."'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
	 $m_user= $row['UserName'] ;
	 $m_pass= $row['Password'];
	 $m_email = $row['EmailId'];
	 $m_fname = $row['fname'];
}

if(!$m_user)
{
?>
<script>
	alert("your account does not exists !!!");
	document.location = "login.php";
</script>
<?php
}
else 
{
	  
    $from = "riteshsharma@iitb.ac.in";
    $to = $m_email;
    $subject = "Password Reset:Virtual Lab!";
    $body = "Hi " . $m_fname . ",\n\n Your Credentials are : \n   UserName :" . $m_user . "\n   Password :" . $m_pass . "\n\n\n Thanks,\n Virtual Labs,\n Urban Transporation Systems Engineering,\n IIT Bombay";

    $host = "smtp-auth.iitb.ac.in";
    $username = "riteshsharma";
    $password = "chintu*";

    $headers = array('From' => $from,
        'To' => $to,
        'Subject' => $subject);
    $smtp = Mail::factory('smtp', array('host' => $host,
                'auth' => true,
                'username' => $username,
                'password' => $password));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        echo("<p>" . $mail->getMessage() . "</p>");
    } else {
        ?>
        <script language="JavaScript">
            alert("An email containing your credential has been sent to your mail id.");
            document.location = "login.php";
        </script>
        <?php
    }
}


?>