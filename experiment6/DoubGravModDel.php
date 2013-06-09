<?php 
session_start();	//To check whether the session has started or not
include_once("../util/system.php");
include"conn.php";	// Database Connection file
include "userchk.php";	//To check user's session

$UploadFile = $_SESSION['user'];
$folder = USER_ROOT."/".$UploadFile."/Experiment6/";
// Retrieving the values of variables

		$m_CostFile = $_GET['CostFile'];
		$m_OriginFile = $_GET['OriginFile'];
		$m_DestFile = $_GET['DestFile'];
	
		$myFile1 = $folder.$m_CostFile;
		$fh1 = fopen($myFile1, 'w') or die("can't open file");
		fclose($fh1);
		unlink($folder.$m_CostFile);	// To delete Cost file  
			
		$myFile2 = $folder.$m_OriginFile;
		$fh2 = fopen($myFile2, 'w') or die("can't open file");
		fclose($fh2);
		unlink($folder.$m_OriginFile);	// To delete Origin file  
		
		$myFile3 = $folder.$m_DestFile;
		$fh3 = fopen($myFile3, 'w') or die("can't open file");
		fclose($fh3);
		unlink($folder.$m_DestFile);  	// To delete Destination file  	
   
?>

<script>
     document.location = "DoubGravMod.php";
</script>