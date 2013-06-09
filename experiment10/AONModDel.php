<?php
include_once("../util/system.php");
session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment10/";

// Retrieving the values of variables

			$UploadFile = $_SESSION['user'];
		
        	$m_NodeFile = $_GET['NodeFile'];
        	$m_ODFile = $_GET['ODFile'];
        	
        	$myFile1 = $folder.$m_NodeFile;
			$fh1 = fopen($myFile1, 'w') or die("can't open file");
			fclose($fh1);
			unlink($folder.$m_NodeFile);	// To delete Node file  
			
			$myFile2 = $folder.$m_ODFile;
			$fh2 = fopen($myFile2, 'w') or die("can't open file");
			fclose($fh2);
			unlink($folder.$m_ODFile);	// To delete OD file  
   
?>

<script>
     document.location = "AONMod.php?Exp=8";
</script>