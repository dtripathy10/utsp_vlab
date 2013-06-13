<?php
include_once("util/system.php");
selectDatabase();
// Retrieving the values of variables

$m_flow = $_GET['flow'];
$m_mode = $_GET['mode'];

$m_user = $_POST['uname'];
$m_pass = $_POST['pass'];
$m_fname = ucfirst($_POST['fname']);
$emp_m_name = ucfirst($_POST['mname']);
$m_lname = ucfirst($_POST['lname']);
//$m_dob=$_POST['dob'];
$t1 = $_POST['DateOfBirth_Year'];
$t2 = $_POST['DateOfBirth_Month'];
$t3 = $_POST['DateOfBirth_Day'];
if(!isset($_POST['DateOfBirth_Year'] )) {
	$t1 = "00";
}
if(!isset($_POST['DateOfBirth_Month'] )) {
	$t2 = "00";
}
if(!isset($_POST['DateOfBirth_Day'] )) {
	$t3 = "00";
}
$m_dob = $t1 . "-" . $t2 . "-" . $t3;
$m_email = $_POST['email'];
$m_mobile = $_POST['c_no'];
$m_course = $_POST['course'];
$m_city = $_POST['city'];
$m_college = $_POST['college'];


// Save the new user record into the database

if ($m_mode == "add") {
    $sql = "insert into UserMaster (`UserName`,`Password`,`FName`,`MName`,`LName`,`DOB`,`EmailId`,`ContactNo`,`course`,`college`,`city`) values('$m_user','$m_pass','$m_fname','$emp_m_name','$m_lname','$m_dob','$m_email','$m_mobile','$m_course','$m_college','$m_city');";
    //echo $sql;
    $result = mysql_query($sql);

    if (!$result) {
        ?>
        <script language="JavaScript">
            alert(<?php mysql_error(); ?>);
            document.location = "signup.php";
        </script>
        <?php
    }
    if ($m_flow == "exit") {
        ?>
        <script language="JavaScript">
            alert("Data Saved Successfully!!!!");
            document.location = "login/index.php";
        </script>
        <?php
    }
}
if ($m_flow == "exit") {
    require_once "Mail/Mail.php";

    $from = "riteshsharma@iitb.ac.in";
    $to = $m_email;
    $subject = "Registration:Virtual Lab!";
    $body = "Hi " . $m_fname . ",\n\n You have successfully registered.\n\n Your Credentials are : \n   UserName :" . $m_user . "\n   Password :" . $m_pass . "\n\n\n Thanks,\n Virtual Labs,\n Urban Transporation Systems Engineering,\n IIT Bombay";

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
            alert("Congratulations! You have successfully registered.Username and password has been sent to your mail");
            document.location = "login/index.php";
        </script>
        <?php
    }
}
?>