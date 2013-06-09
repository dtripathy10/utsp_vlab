<?php
include_once("../util/system.php");

session_start();

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];
$m_TripFile = $_POST['TripFile'];

$myFile = USER_ROOT."/".$UploadFile."/Experiment2/".$m_TripFile;
$fh = fopen($myFile, 'w') or die("can't open file");
fclose($fh);

unlink($myFile);	//To delete trip file  	
?>

<script>
     document.location = "DataRegrMod.php?Exp=1";
</script>