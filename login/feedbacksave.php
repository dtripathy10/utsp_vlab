<?php

session_start(); //To check whether the session has started or not
include_once("../util/system.php");
selectDatabase();


// Retrieving the values of variables


$m_exp = $_POST["experiment"];
$UsrId = $_SESSION['uid'];
$email = $_SESSION['EmlId'];

$ColUniName = $_POST['institute'];
$VLab = 'UTSP';

$Rate1 = $_POST['Rate1'];
$Rate2 = $_POST['Rate2'];
$Rate3 = $_POST['Rate3'];

$helpful = $_POST['helpful'];

$Quest1 = $_POST['Quest1'];
$Quest2 = $_POST['Quest2'];
$Quest3 = $_POST['Quest3'];
$Quest4 = $_POST['Quest4'];
$Quest5 = $_POST['Quest5'];
$Quest6 = $_POST['Quest6'];

$ProblemDetails = $_POST['problems'];
$interesting = $_POST['interesting'];


$date_time = date('Y-m-d H:i:s');
$submit = $_POST['Submit'];


// Saving records into Database

if ($submit) {
    foreach ($m_exp as $ExpNo1) {
        $sql = "insert into feedbackdetails1 (ExpNo,UsrNo,EmailId,Institute,Vlab,Rate1,Rate2,Rate3,helpful,Quest1,Quest2,Quest3,Quest4,Quest5,Quest6,ProblemDetails,InterestingDetails,DateOfFeedBack) values('$ExpNo1','$UsrId','$email','$ColUniName','$VLab','$Rate1','$Rate2','$Rate3','$helpful','$Quest1','$Quest2','$Quest3','$Quest4','$Quest5','$Quest6','$ProblemDetails','$interesting','$date_time');";
        $result = mysql_query($sql);
        if (!$result) {
            die("ERROR: " . mysql_error() . "\n");
        }
    }
    ?>
    <script language="JavaScript">
        alert("Feedback Saved Successfully!!!!");
        document.location = "index.php";
        //window.history.back();				
    </script>
    <?php

}
?>
