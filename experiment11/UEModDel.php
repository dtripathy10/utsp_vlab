<?php 
session_start();	//To check whether the session has started or not

// Retrieving the values of variables

$UploadFile = $_SESSION['user'];
$folder = "../user/".$UploadFile."/Experiment11/";
		
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
     document.location = "UEMod.php?Exp=9";
</script>