<?php
include_once("../util/system.php");

// Retrieving the values of variables

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment12/";


echo $m_NodeFile = $_GET['NodeFile'];
echo $m_OdFile = $_GET['OdFile'];
        	
$myFile1 = $folder.$m_NodeFile;
$fh1 = fopen($myFile1, 'w') or die("can't open file");
fclose($fh1);
unlink($folder.$m_NodeFile);	// To delete Node file  

$myFile2 = $folder.$m_OdFile;
$fh2 = fopen($myFile2, 'w') or die("can't open file");
fclose($fh2);
unlink($folder.$m_OdFile);		// To delete OD file  	
   
?>

<script>
     document.location = "SystemOptMod.php?Exp=10";
</script>